<?

use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */

?>

<div class="accordion accordion-faq accordion-faq--solid" id="faq">

    <? foreach ($model->faqs as $i => $faq): ?>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $i ?>" aria-controls="collapse<?= $i ?>">
                    <?= $faq->from ?>
                </button>
            </h2>
            <div id="collapse<?= $i ?>" class="accordion-collapse collapse " data-bs-parent="#faq">
                <div class="accordion-body">
                    <p>
                        <?= $faq->value ?>
                    </p>
                </div>
            </div>
        </div>

    <? endforeach; ?>


</div>
