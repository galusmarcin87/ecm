<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'Register');

?>

<div class="page-header " style="background-image:url(/images/page-header.jpg);">
    <div class="page-header-content">
    <div class="container">
        <h1 class="page-header-title">
            <?= $this->title ?>
        </h1>

        <div class="breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					

					<? if (isset($this->params['breadcrumbs'])): ?>
					<? foreach ($this->params['breadcrumbs'] as $item): ?>
					<? if (is_array($item)) : ?>
					<li class="breadcrumb-item"><a href="<?= $item[0] ?>"><?= $item[1] ?></a></li>
					<? else: ?>
					<li class="breadcrumb-item"><?= $item ?></li>
					<? endif; ?>
					<? endforeach; ?>
					<? endif; ?>
					<li class="breadcrumb-item active" aria-current="page"><?= $this->title ?></li>
				</ol>
            </nav>
        </div>        
    </div>
	</div>
</div>

<div class="container">

    <?php
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'contact-form login__form'],
        'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(true)
    ]);

    echo $form->errorSummary($model);
    ?>
	
	
	
	
	
	<div class="bg-lg-half-decoration py-7 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bg-decoration-content">
                <div class="ps-lg-10">
                    <div class="row">
						
						
						
                        <div class="col-lg-8 offset-lg-1">
           <form action="#">
					
			<div class="mb-4">
                <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
			</div>
			   
			<div class="mb-4">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
			</div>
			   
            <div class="mb-4">
                <?= $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => $model->getAttributeLabel('passwordRepeat')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'firstName')->textInput(['placeholder' => $model->getAttributeLabel('firstName')]) ?>
            </div>
			   
			<div class="mb-4">
                <?= $form->field($model, 'surname')->textInput(['placeholder' => $model->getAttributeLabel('surname')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'birthDate')->textInput(["onfocus" => "(this.type='date')", 'placeholder' => $model->getAttributeLabel('birthDate')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'street')->textInput(['placeholder' => $model->getAttributeLabel('street')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'houseNo')->textInput(['placeholder' => $model->getAttributeLabel('houseNo')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'flatNo')->textInput(['placeholder' => $model->getAttributeLabel('flatNo')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'postalCode')->textInput(['placeholder' => $model->getAttributeLabel('postalCode')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'city')->textInput(['placeholder' => $model->getAttributeLabel('city')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'voivodeship')->textInput(['placeholder' => $model->getAttributeLabel('voivodeship')]) ?>
            </div>
			   
			<div class="form-check form-check-acceptance mb-4">
                <div class="Form__group form-group text-left checkbox">
                    <?= $form->field($model, 'acceptTerms',
                        [
                            'checkboxTemplate' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['encode' => false]
                        ]
                    )->checkbox(['class' => 'form-check-input', 'label' => $model->getAttributeLabel('acceptTerms')])->label(true); ?>
                </div>
            </div>
			   
            <div class="text-center mb-6">
                <button type="submit" class="btn btn-primary">
                    <?= Yii::t('db', 'Register') ?>
                </button>
            </div>


                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
    </div>
</div>

    <?php ActiveForm::end(); ?>


</div>
