<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;
use yii\web\UploadedFile;
use yii\db\Expression;

/**
 *
 * @property \app\models\mgcms\db\File[] $files
 * @property \app\models\mgcms\db\FileRelation[] $fileRelations
 */
class AbstractRecord extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait {
        saveAll as saveAllRelationTrait;
    }

    public $uploadedFiles;
    public $onlyOneFile = false;
    public $modelAttributes = [];

    public function save($runValidaton = true, $attributes = null)
    {
        // fill in created on & by, amended on & by values
        if ($this->isNewRecord) {
            if ($this->hasAttribute('created_on'))
                $this->created_on = new Expression('NOW()');
            if ($this->hasAttribute('created_by') && isset(Yii::$app->user) && $id = Yii::$app->user->getId()) {
                $this->created_by = $id;
            }
            if ($this->hasAttribute('timestamp'))
                $this->timestamp = new Expression('NOW()');
        } else {
            if ($this->hasAttribute('updated_on'))
                $this->updated_on = new Expression('NOW()');
            if ($this->hasAttribute('updated_by') && isset(Yii::$app->user) && $id = Yii::$app->user->getId())
                $this->updated_by = $id;
            if ($this->hasAttribute('timestamp'))
                $this->timestamp = new Expression('NOW()');
        }

        $saved = parent::save($runValidaton, $attributes);
        return $saved;
    }

    /**
     * return enum array of column
     * @param type $column
     * @return type
     */
    public function getColumnEnumArray($column)
    {
        $schema = Yii::app()->db->getSchema()->getTable($this->tableName())->getColumn($column)->dbType;

        preg_match_all("/'([^']+)'/", $schema, $items);
        $items = array_combine($items[1], $items[1]);
        return $items;
    }

    public function getRelArray($rel, $field = 'id', $force = false)
    {
        $retArray = array();
        foreach ($this->{$rel} as $model) {
            array_push($retArray, $model->{$field});
        }

        return $retArray;
    }

    public function getToString()
    {
        return (string)$this;
    }

    public function getThumb($width = 100, $height = 100, $field = 'file', $setPrettyPhoto = true)
    {
        if ($setPrettyPhoto)
            MgHelpers::setPrettyPhoto();
        return isset($this->$field) && $this->$field && is_object($this->$field) && method_exists(get_class($this->$field), 'getThumb') ? $this->$field->getThumb($width, $height) : false;
    }

    public function getImage($width = 0, $height = 0, $field = 'file', $htmlOptions = array())
    {
        return isset($this->$field) && $this->$field && is_object($this->$field) && method_exists(get_class($this->$field), 'getThumb') ? $this->$field->getThumb($width, $height, $htmlOptions) : false;
    }

    public function __toString()
    {
        if ($this->hasAttribute('name')) {
            return $this->getAttribute('name');
        } else {
            return get_class($this) . ' id: ' . $this->id;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {

        $query = \app\models\mgcms\db\File::find();
        $query->multiple = true;
        $query->innerJoin('file_relation', 'file_relation.file_id = file.id');
        $query->andWhere(['file_relation.model' => $this::className(), 'file_relation.rel_id' => $this->id]);
        $query->orderBy(['file_relation.order' => SORT_ASC]);
        $query->link = [];

        return $query;
        //nie działający orderby bo jest rozdzielone na 2 zapytania i jest IN(  )
//    return $this->hasMany(\app\models\mgcms\db\File::className(), ['id' => 'file_id'])
//            ->viaTable('file_relation', ['rel_id' => 'id'], function($query) {
//              /** @var $query \yii\db\ActiveQuery * */
//              $query->andWhere(['model' => $this::className()]);
//              $query->orderBy('file_relation.order ASC'); //@TOTO YII2 dont work
//            });
    }

    public function getFileRelations()
    {
        return $this->hasMany(\app\models\mgcms\db\FileRelation::className(), ['rel_id' => 'id'])->where(['model' => $this::className()])->orderBy('`order` ASC');
    }

    public function afterSave($insert, $changedAttributes)
    {
        $saved = parent::afterSave($insert, $changedAttributes);
        $this->assignFiles();
        $this->setFileOrder(Yii::$app->request->post('fileOrder', []));
        return $saved;
    }

    public function assignFiles()
    {
        $upladedFiles = UploadedFile::getInstances($this, 'uploadedFiles');

        if ($upladedFiles) {
            foreach ($upladedFiles as $CUploadedFileModel) {
                if ($CUploadedFileModel->hasError) {
                    MgHelpers::setFlash(MgHelpers::FLASH_TYPE_ERROR, Yii::t('app', 'Error with uploading file - probably file is too big'));
                    continue;
                }
                $fileModel = new File;
                $file = $fileModel->push(new \rmrevin\yii\module\File\resources\UploadedResource($CUploadedFileModel));
                $file->created_by = MgHelpers::getUserModel()->id;
                $file->save();
                if ($file) {
                    if ($this->onlyOneFile) {
                        foreach ($this->fileRelations as $fileRelation) {
                            $fileRelation->delete();
                        }
                    }
                    if (FileRelation::find()->where(['file_id' => $file->id, 'rel_id' => $this->id, 'model' => $this::className()])->count()) {
                        continue;
                    }
                    $fileRel = new FileRelation;
                    $fileRel->file_id = $file->id;
                    $fileRel->rel_id = $this->id;
                    $fileRel->model = $this::className();
                    MgHelpers::saveModelAndLog($fileRel);
                } else {
                    MgHelpers::setFlashError('Błąd dodawania pliku powiązanego');
                }
            }
            return true;
        }
        return false;
    }

    public function saveAll($skippedRelations = array())
    {
        $skippedRelations = \yii\helpers\ArrayHelper::merge($skippedRelations, ['files', 'fileRelations', 'tags']);
        return $this->saveAllRelationTrait($skippedRelations);
    }

    public function setModelAttribute($key, $value)
    {
        if (!$this->id) {
            return false;
        }
        $modelAttribute = ModelAttribute::find()->where(['rel_id' => $this->id, 'model' => $this::className(), 'key' => $key])->one();
        if (!$modelAttribute) {
            $modelAttribute = new ModelAttribute;
        }
        if (!$this->id) {
            return false;
        }
        $modelAttribute->rel_id = $this->id;
        $modelAttribute->model = $this::className();
        $modelAttribute->key = $key;
        $modelAttribute->value = $value;
        MgHelpers::saveModelAndLog($modelAttribute);
    }

    public function getModelAttribute($key, $isJson = false)
    {
        $modelAttribute = ModelAttribute::find()->where(['rel_id' => $this->id, 'model' => $this::className(), 'key' => $key])->one();
        if ($modelAttribute) {
            return $isJson ? \yii\helpers\Json::decode($modelAttribute->value) : $modelAttribute->value;
        } else {
            return null;
        }
    }

    public function __get($name)
    {
        if (in_array($name, $this->modelAttributes)) {
            return $this->getModelAttribute($name);
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->modelAttributes)) {
            return $this->setModelAttribute($name, $value);
        }
        return parent::__set($name, $value);
    }

    /**
     *
     * @param array $fileIds
     */
    public function setFileOrder($fileIds)
    {
        $n = 1;
        if ($this->hasAttribute('id')) {
            foreach ($fileIds as $id => $null) {
                $fileRel = \app\models\mgcms\db\FileRelation::find()->where(['rel_id' => $this->id, 'file_id' => $id, 'model' => $this::className()])->one();
                if ($fileRel) {
                    $fileRel->order = $n;
                    $fileRel->save();
                }
                $n++;
            }
        }
    }

    public function delete()
    {
        try {
            return parent::delete();
        }catch (yii\db\IntegrityException  $e){
            MgHelpers::setFlashError(Yii::t('app', 'Problem with deletion. You need to remove all relational object first'));
            return false;
        }

    }
}
