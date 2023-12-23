<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;

$faq = \app\models\mgcms\db\Faq::find()->where(['lang' => Yii::$app->language, 'type' => \app\models\mgcms\db\Faq::TYPE_FAQ])->one();
if (!$faq) {
    return false;
}

?>


<section class="Section animatedParent Section--light-background">
    <div class="container fadeIn animated">
        <h1 class="text-center"><?= Yii::t('db', 'FAQ'); ?></h1>
        <div
                class="Accordion animatedParent"
                id="accordion_custom"
                role="tablist"
        >
            <div class="Accordion__tabs">
                <? foreach ($faq->faqItems as $item): ?>
                    <?= $this->render('/faq/_index',['model' => $item])?>

                <? endforeach; ?>


            </div>
            <div class="Accordion__text"></div>
        </div>
    </div>
</section>
