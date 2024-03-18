<?

use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */


?>

<aside class="project-nav">
    <h4><?= Yii::t('db', 'See') ?>:</h4>
    <div>
        <? foreach ($model->fileRelations as $relation): ?>
            <? if ($relation->json != Yii::$app->language || !$relation->file) continue ?>
            <div>
                <a href="<?= $relation->file->linkUrl ?>" class="project-btn d-block">
                    <?= $relation->file->origin_name ?>
                </a><br>
            </div>
        <? endforeach ?>
    </div>
</aside>
