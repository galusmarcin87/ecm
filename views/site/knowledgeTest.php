<?php
/* @var $this yii\web\View */

/* @var $model \app\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'Knowledge test');


?>

<?= $this->render('/common/breadcrumps') ?>

<div class="container">
    <?php
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'contact-form login__form'],
    ]);
    ?>

    <div class="survey">
        <? foreach ($config['sections'] as $sectionIndex => $section): ?>
            <div class="survey-block">
                <h2 class="survey-title">
                    <?= $section['name'] ?>
                </h2>

                <? foreach ($section['questions'] as $questionIndex => $question): ?>
                    <?= $this->render('knowledgeTest/_question', [
                        'sectionIndex' => $sectionIndex,
                        'questionIndex' => $questionIndex,
                        'question' => $question,
                    ]) ?>


                    <? if (isset($question['subquestions'])): ?>
                        <p><strong>W przypadku wyboru odpowiedzi „tak” w zakresie co najmniej jednego z powyższych
                                punktów prosimy o Udzielenie dodatkowych odpowiedzi na pytania <br/>
                                <?= $questionIndex + 1 ?>.1. – <?= $questionIndex + 1 ?>
                                .<?= count($question['subquestions']) ?>. poniżej</strong></p>
                        <? foreach ($question['subquestions'] as $subQuestionIndex => $subQuestion): ?>
                            <?= $this->render('knowledgeTest/_question', [
                                'sectionIndex' => $sectionIndex,
                                'questionIndex' => $questionIndex,
                                'subQuestionIndex' => $subQuestionIndex,
                                'question' => $subQuestion,
                                'isSubquestion' => true
                            ]) ?>
                        <? endforeach ?>

                    <? endif; ?>

                <? endforeach; ?>


            </div>
        <? endforeach; ?>

        <h2 class="survey-title">
            <?= Yii::t('db', 'Client statement') ?>
        </h2>

        <div class="form-check form-check-acceptance mb-4">
            <input class="form-check-input" type="checkbox" value="" id="acceptance1" required>
            <label class="form-check-label" for="acceptance1">
                <?= MgHelpers::getSettingTypeText('knowledge test - term ' . Yii::$app->language, true, 'Oświadczam, że wskazane przeze mnie odpowiedzi na pytania zawarte w powyższym teście są rzetelne
                oraz potwierdzam, że OpalCrowd nie zachęcał ani nie sugerował mi nieprzedstawiania informacji
                objętych testem. Przyjmuję do wiadomości, że w przypadku podania nieprawdziwych informacji,
                OpalCrowd nie ponosi odpowiedzialności za dokonaną ocenę.')?>

            </label>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary"><?= Yii::t('db', 'Next') ?></button>
        </div>


    </div>
    <?php ActiveForm::end(); ?>
</div>



