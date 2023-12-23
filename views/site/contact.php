<?php
/* @var $this yii\web\View */

/* @var $model \app\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

$this->title = MgHelpers::getSettingTranslated('contact_header', 'Contact');


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

<div class="contact-page">
    <div class="container">
        <div class="row align-items-center py-6">
            <div class="col-lg-4">
				
                <div class="contact-info">
                    <div class="contact-info-icon">
                        <svg class="icon">
                            <use xlink:href="#info">
                        </svg>
                    </div>
                    <div class="contact-info-text pt-3">
                        <p>
                          <?= MgHelpers::getSettingTypeText('contact - information' . Yii::$app->language, true) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info">
                    <div class="contact-info-icon">
                        <svg class="icon">
                            <use xlink:href="#pin">
                        </svg>
                    </div>
                    <div class="contact-info-text pt-3">
                        <?= MgHelpers::getSettingTypeText('contact - address' . Yii::$app->language, true) ?>
                    </div>
                    </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info">
                    <div class="contact-info-icon">
                        <svg class="icon">
                            <use xlink:href="#envelope">
                        </svg>
                    </div>
                    <div class="contact-info-text pt-3">
                        <?= MgHelpers::getSettingTypeText('contact - mail' . Yii::$app->language, true) ?>
                    </div>
                    </div>
            </div>
        </div>

    </div>
</div>
			
<div class="section-newsletter" style="background-image:url(/images/newsletter-bg.jpg);">
<div class="section-content">
    <div class="container">
        <div class="row align-items-center gx-lg-5">
            <div class="col-lg-7">
                <h2 class="section-title text-primary">
                    Strefa inwestora
                </h2>
                <p class="fs-5 text-uppercase">
                    Bądź zawsze na bieżąco! dołącz do grupy inwestorów 
                    i miej możliwość uczestniczenia w naszych najnowszych projektach inwestycyjnych.
                    <form action="#" class="newsletter-form">
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Wpisz swój adres e-mail" aria-label="Adres email odbiorcy newslettera">
                            <button class="btn" type="button">
                                Zapisz się 
                                <svg class="icon">
                                    <use xlink:href="#chevron-right"></use>
                                </svg>

                            </button>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="gdpr1">
                            <label class="form-check-label" for="gdpr1">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="gdpr2">
                            <label class="form-check-label" for="gdpr2">
                                Wyrażam zgodę na przetwarzanie swoich danych posobowych....
                            </label>
                        </div>

                    </form>
                </p>
            </div>
            <div class="col-6 col-lg-4 mx-auto">

                <img src="/assets/images/newsletter-invest.png" alt="" class="img-fluid">
            </div>

        </div>
    </div>
    </div>
</div>

		
<div class="contact-form-section py-6">
    <div class="container">
        <form action="#" class="contact-form">
			
			<?php
                $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(true)
                ]);

                echo $form->errorSummary($model);
                ?>
			
            <h3 class="fw-bold font-oswald text-uppercase mb-5"><?= Yii::t('db', 'Questions?') ?></h3>

            <div class="row">
                <div class="col-lg-10 mx-auto">

                    <div class="mb-4">
                        <?= $form->field($model, 'name')->textInput(['placeholder' => $model->getAttributeLabel('name')]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'phone')->textInput(['placeholder' => $model->getAttributeLabel('phone')]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
                    </div>


            

                    <div class="mb-4">
                        <?= $form->field($model, 'body')->textarea(['placeholder' => $model->getAttributeLabel('body'), 'rows' => 6]) ?>
                    </div>

                    <div class="form-check form-check-acceptance mb-4">
                            <?= $form->field($model, 'acceptTerms',[
                            'options' => [
                                'class' => "Form__group form-group",
                            ],
                            'checkboxTemplate' => "{input}\n{label}\n{error}",
                        ]
                    )->checkbox(['class' => 'form-check-input']) ?>
                        </div>
					
                        <div class="form-check form-check-acceptance mb-6">
                            <?= $form->field($model, 'acceptTerms2',[
                            'options' => [
                                'class' => "Form__group form-group",
                            ],
                            'checkboxTemplate' => "{input}\n{label}\n{error}",
                        ]
                    )->checkbox(['class' => 'form-check-input']) ?>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary btn-wide" type="submit"><?= Yii::t('db', 'Send') ?></button>
                        </div>
<?php ActiveForm::end(); ?>

                    
                </div>
            </div>
        </form>
    </div>
</div>
