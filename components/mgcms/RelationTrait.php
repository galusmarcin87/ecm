<?php
namespace app\components\mgcms;

use Yii;
use yii\db\ActiveQuery;
use \yii\db\ActiveRecord;
use \yii\db\Exception;
use yii\db\IntegrityException;
use \yii\helpers\Inflector;
use \yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;

/*
 *  add this line to your Model to enable soft delete
 *
 *
 *
 * function __construct(){
 *      $this->_rt_softdelete = [
 *          '<column>' => <undeleted row marker value>
 *          // multiple row marker column example
 *          'isdeleted' => 1,
 *          'deleted_by' => \Yii::$app->user->id,
 *          'deleted_at' => date('Y-m-d H:i:s')
 *      ];
 * }
 * add this line to your Model to enable soft restore
 * private $_rt_softrestore;
 *
 * function __construct(){
 *      $this->_rt_softrestore = [
 *          '<column>' => <undeleted row marker value>
 *          // multiple row marker column example
 *          'isdeleted' => 0,
 *          'deleted_by' => 0,
 *          'deleted_at' => 'NULL'
 *      ];
 * }
 */

trait RelationTrait
{

    use \mootensai\relation\RelationTrait;

    public $saveAllNoChildren = false;

    /**
     * Save model including all related model already loaded
     * @param array $skippedRelations
     * @return bool
     * @throws Exception
     */
    public function saveAll($skippedRelations = [])
    {
        /* @var $this ActiveRecord */
        $db = $this->getDb();
        $trans = $db->beginTransaction();
        $isNewRecord = $this->isNewRecord;
        $isSoftDelete = isset($this->_rt_softdelete);
        try {
            if ($this->save()) {
                $error = false;
                if (!empty($this->relatedRecords)) {
                    /* @var $records ActiveRecord | ActiveRecord[] */
                    foreach ($this->relatedRecords as $name => $records) {
                        if (in_array($name, $skippedRelations))
                            continue;

                        $AQ = $this->getRelation($name);
                        $link = $AQ->link;
                        if (!empty($records)) {
                            $notDeletedPK = [];
                            $notDeletedFK = [];
                            $relPKAttr = ($AQ->multiple) ? $records[0]->primaryKey() : $records->primaryKey();
                            $isManyMany = (count($relPKAttr) > 1);
                            if ($AQ->multiple) {
                                /* @var $relModel ActiveRecord */
                                foreach ($records as $index => $relModel) {
                                    foreach ($link as $key => $value) {
                                        if ($this->hasAttribute($value)) {
                                            $relModel->$key = $this->$value;
                                            $notDeletedFK[$key] = $this->$value;
                                        }
                                    }

                                    //GET PK OF REL MODEL
                                    if ($isManyMany) {
                                        $mainPK = array_keys($link)[0];
                                        foreach ($relModel->primaryKey as $attr => $value) {
                                            if ($attr != $mainPK) {
                                                $notDeletedPK[$attr][] = $value;
                                            }
                                        }
                                    } else {
                                        $notDeletedPK[] = $relModel->primaryKey;
                                    }
                                }

                                if (!$isNewRecord) {
                                    //DELETE WITH 'NOT IN' PK MODEL & REL MODEL
                                    if ($isManyMany) {
                                        // Many Many
                                        $query = ['and', $notDeletedFK];
                                        foreach ($notDeletedPK as $attr => $value) {
                                            $notIn = ['not in', $attr, $value];
                                            array_push($query, $notIn);
                                        }
                                        try {
                                            if (isset($relModel::$softDeleteAttribute) && isset($relModel->softDeleteTrait) && $relModel->softDeleteTrait) {
                                                $relModel->updateAll($this->_rt_softdelete, $query);
                                            } else {
                                                $relModel->deleteAll($query);
                                            }
                                        } catch (IntegrityException $exc) {
                                            $this->addError($name, "Data can't be deleted because it's still used by another data.");
                                            $error = true;
                                        }
                                    } else {
                                        // Has Many
                                        $query = ['and', $notDeletedFK, ['not in', $relPKAttr[0], $notDeletedPK]];
                                        if (!empty($notDeletedPK)) {
                                            try {
                                                $notDeletedPK = array_filter($notDeletedPK);
                                                if (empty($notDeletedPK)) {
                                                    // new record was added and old records were deleted
                                                    $query = [];
                                                } else {
                                                    $query = [
                                                        'and',
                                                        $notDeletedFK,
                                                        ['not in', $relPKAttr[0], $notDeletedPK]
                                                    ];
                                                }

//                        if (isset($relModel::$softDeleteAttribute) && isset($relModel->softDeleteTrait) && $relModel->softDeleteTrait) {
//                          $relModel->setAttribute($relModel::$softDeleteAttribute,1);
//                          $relModel->save();
//                        } else {
                                                if (isset($relModel::$softDeleteAttribute) && isset($relModel->softDeleteTrait) && $relModel->softDeleteTrait) {
                                                    if (empty($query)) {
                                                        $query = ['and', $notDeletedFK];
                                                    }
                                                    $relModel->updateAll($this->_rt_softdelete, $query);
                                                } else {
                                                    if (empty($query)) {
                                                        $query = ['and', $notDeletedFK];
                                                    }
                                                    $relModel->deleteAll($query);
                                                }
//                        }
                                            } catch (IntegrityException $exc) {
                                                $this->addError($name, "Data can't be deleted because it's still used by another data.");
                                                $error = true;
                                            }
                                        }
                                    }
                                }

                                foreach ($records as $index => $relModel) {
                                    $relSave = $relModel->save();

                                    if (!$relSave || !empty($relModel->errors)) {
                                        $relModelWords = Yii::t('app', Inflector::camel2words(StringHelper::basename($AQ->modelClass)));
                                        $index++;
                                        foreach ($relModel->errors as $validation) {
                                            foreach ($validation as $errorMsg) {
                                                $this->addError($name, "$relModelWords #$index : $errorMsg");
                                            }
                                        }
                                        $error = true;
                                    }
                                }
                            } else {
                                //Has One
                                foreach ($link as $key => $value) {
                                    $records->$key = $this->$value;
                                }
                                $relSave = $records->save();
                                if (!$relSave || !empty($records->errors)) {
                                    $recordsWords = Yii::t('app', Inflector::camel2words(StringHelper::basename($AQ->modelClass)));
                                    foreach ($records->errors as $validation) {
                                        foreach ($validation as $errorMsg) {
                                            $this->addError($name, "$recordsWords : $errorMsg");
                                        }
                                    }
                                    $error = true;
                                }
                            }
                        }
                    }
                }

                if (isset($_POST['deletedRelations'])) {
                    $deletedRelations = array_unique(explode(',', $_POST['deletedRelations']));
                    foreach ($deletedRelations as $deletedRelation) {
                        if(isset($_POST[$deletedRelation])){
                            continue;
                        }
                        $relDelModels = lcfirst($deletedRelation) . 's';
                        if ($this->hasProperty($relDelModels)) {
                            foreach ($this->$relDelModels as $relDelModel) {
                                if ($relDelModel instanceof \app\models\mgcms\db\AbstractRecord) {
                                    $relDelModel->delete();
                                }
                            }
                        }
                    }
                }

                //No Children left
                $relAvail = array_keys($this->relatedRecords);
                $relData = $this->getRelationData();
                $allRel = array_keys($relData);
                $noChildren = array_diff($allRel, $relAvail);
                if ($this->saveAllNoChildren) {
                    foreach ($noChildren as $relName) {
                        /* @var $relModel ActiveRecord */
                        if (empty($relData[$relName]['via']) && !in_array($relName, $skippedRelations)) {
                            $relModel = new $relData[$relName]['modelClass'];
                            $condition = [];
                            $isManyMany = count($relModel->primaryKey()) > 1;
                            if ($isManyMany) {
                                foreach ($relData[$relName]['link'] as $k => $v) {
                                    $condition[$k] = $this->$v;
                                }
                                try {
                                    if ($isSoftDelete) {
                                        $relModel->updateAll($this->_rt_softdelete, ['and', $condition]);
                                    } else {
                                        $relModel->deleteAll(['and', $condition]);
                                    }
                                } catch (IntegrityException $exc) {
                                    $this->addError($relData[$relName]['name'], Yii::t('mtrelt', "Data can't be deleted because it's still used by another data."));
                                    $error = true;
                                }
                            } else {
                                if ($relData[$relName]['ismultiple']) {
                                    foreach ($relData[$relName]['link'] as $k => $v) {
                                        $condition[$k] = $this->$v;
                                    }
                                    try {
                                        if ($isSoftDelete) {
                                            $relModel->updateAll($this->_rt_softdelete, ['and', $condition]);
                                        } else {
                                            $relModel->deleteAll(['and', $condition]);
                                        }
                                    } catch (IntegrityException $exc) {
                                        $this->addError($relData[$relName]['name'], Yii::t('mtrelt', "Data can't be deleted because it's still used by another data."));
                                        $error = true;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($error) {
                    $trans->rollback();
                    $this->isNewRecord = $isNewRecord;
                    return false;
                }
                $trans->commit();
                return true;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            $trans->rollBack();
            $this->isNewRecord = $isNewRecord;
            throw $exc;
        }
    }
}
