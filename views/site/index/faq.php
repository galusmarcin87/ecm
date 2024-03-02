<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\web\View;

$faq = \app\models\mgcms\db\Faq::find()->where(['lang' => Yii::$app->language, 'type' => \app\models\mgcms\db\Faq::TYPE_FAQ])->one();
if (!$faq) {
    return false;
}

?>


<div class="section-faq py-5">
	<div class="container">
		<h2 class="section-title text-center">
			<?= Yii::t('db', 'FAQ'); ?>
        </h2>
		<div class="accordion accordion-faq" id="faq">
            <? foreach ($faq->faqItems as $i => $item): ?>
                <?if ($i > 2) continue; ?>
                <?= $this->render('/faq/_index',['model' => $item])?>
            <? endforeach; ?>

            <div class="my-5 text-center">
                <a href="<?= $faq->getLinkUrl()?>" class="btn btn-primary btn-wide"><?= Yii::t('db', 'See all') ?></a>
            </div>

    </div>
</div>
