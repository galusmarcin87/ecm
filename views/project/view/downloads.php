<?

use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */


?>
<div class="files">

    <? foreach ($model->fileRelations as $relation): ?>
        <? if ($relation->json != '1' || !$relation->file) continue ?>
        <a href="<?= $relation->file->linkUrl ?>" class="media file-download">
            <span class="file-icon">
                <img class="icon" src="/images/files/file-generic.svg"/>
            </span>
            <span class="file-title">
                <div class="file-title-main">
                    <?= $relation->file->origin_name ?>
                </div>
            </span>
        </a>
    <? endforeach ?>


</div>
