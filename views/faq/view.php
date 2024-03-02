<?php
/* @var $model app\models\mgcms\db\FaqItem */
use app\components\mgcms\MgHelpers;
$this->title = $model->question;

?>

<main>
  <section class="text-box blog">
    <div class="container">
      <h2><span><span><span></span></span> <?= \yii\helpers\Html::encode($this->title) ?><span><span></span> </span></span></h2>
      <div class="row">
        <div class="col-lg-12">
          <?= $model->content ?>
        </div>
      </div>
    </div>
  </section>
</main> 