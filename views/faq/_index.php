<?
/* @var $model app\models\mgcms\db\FaqItem */

?>
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $model->id ?>"  aria-controls="collapse<?= $model->id ?>">
            <?= $model->question ?>
        </button>
    </h2>
    <div id="collapse<?= $model->id ?>" class="accordion-collapse collapse " data-bs-parent="#faq">
        <div class="accordion-body">
            <p>
                <?= $model->answer ?>
            </p>
        </div>
    </div>
</div>
