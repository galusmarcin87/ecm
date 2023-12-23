<?
/* @var $this yii\web\View */
?>
<div class="">
    <h3><?= Yii::t('db', 'Share') ?></h3>
    <div class="social-icons social-icons--color">
        <?= \ymaker\social\share\widgets\SocialShare::widget([
            'configurator' => 'socialShare',
            'url' => \yii\helpers\Url::current([], true),
            'title' => $title,
            'description' => $description,
            'imageUrl' => $image,
            'containerOptions' => [
                'class' => 'social-icons social-icons--color',
                'tag' => 'div'
            ], 'linkContainerOptions' => ['tag' => false]
        ]); ?>
    </div>
</div>
