<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\CompanySearch */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/jquery.nestable.js');
$this->registerCssFile('@web/css/nestable.css');

$user = MgHelpers::getUserModel();
$tree = pushUsers($user );

function pushUsers(\app\models\mgcms\db\User &$parent)
{
    $users = \app\models\mgcms\db\User::find()->where(['created_by' => $parent->id])->all();
    $parent->children = $users;
    foreach ($parent->children as &$user) {
        pushUsers($user);
    }
}


?>

<div class="form-company-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'id'=>'searchForm',
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'created_by')->hiddenInput(['maxlength' => true, 'placeholder' => 'Companycol1']) ?>

    <div class="row-fluid dd" id="menuNestable">
        <?php echo $this->render('_submenu', array('items' => $user->children)); ?>
    </div>

    <div class="form-group">
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default reset']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$('.dd-handle').click(function(){
    $('.dd-handle').removeClass('active');
    $(this).toggleClass('active');
    $('#companysearch-created_by').val($(this).data('user-id'));
    $('#searchForm').submit();
});

$('.btn-default.reset').click(function(){
    $('#companysearch-created_by').val('');
    $('#searchForm').submit();
});
</script>
