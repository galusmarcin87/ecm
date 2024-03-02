<?php
/* @var $this \yii\web\View */
/* @var $content string */
use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\backend\assets\BackendAssets;
use kartik\icons\Icon;

BackendAssets::register($this);

AppAsset::register($this);
Icon::map($this, Icon::BSG);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
  </head>
  <body id="page_<?= str_replace('/', '_', Yii::$app->controller->id . '_' . Yii::$app->controller->action->id) ?>">
    <?php $this->beginBody() ?>

    <div class="wrap">
      <?= $this->context->renderPartial('/layouts/nav') ?>

      <div class="container">
        <?=
        Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])

        ?>
        <?= Alert::widget() ?>
        <?= $content ?>
      </div>
    </div>

    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
