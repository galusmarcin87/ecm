<?

use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */


?>

<aside class="project-nav">
    <h4><?= Yii::t('db', 'See') ?>:</h4>
    <div class="row gy-3">
        <? foreach ($model->fileRelations as $relation): ?>
            <? if ($relation->json != '1' || !$relation->file) continue ?>
            <div class="col-md-6">
                <a href="<?= $relation->file->linkUrl ?>" class="project-btn d-block">
                    <?= $relation->file->origin_name ?>
                </a>
            </div>

        <? endforeach ?>
    </div>
</aside>
