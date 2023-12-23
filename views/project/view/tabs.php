<?

use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */


?>
<ul class="nav nav-tabs" id="myTab" role="tablist">

    <li class="nav-item" role="presentation">
        <button class="nav-link " id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button"
                role="tab" aria-controls="about" aria-selected="true"><?= Yii::t('db', 'About project') ?></button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link " id="board-tab" data-bs-toggle="tab" data-bs-target="#board" type="button"
                role="tab" aria-controls="board" aria-selected="true"><?= Yii::t('db', 'Management') ?></button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link " id="investments-tab" data-bs-toggle="tab" data-bs-target="#investments"
                type="button" role="tab" aria-controls="investments"
                aria-selected="true"><?= Yii::t('db', 'Investitions') ?></button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link " id="downloads-tab" data-bs-toggle="tab" data-bs-target="#downloads" type="button"
                role="tab" aria-controls="downloads" aria-selected="true"><?= Yii::t('db', 'Download') ?></button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link " id="risks-tab" data-bs-toggle="tab" data-bs-target="#risks" type="button"
                role="tab" aria-controls="risks"
                aria-selected="true"><?= Yii::t('db', 'Significant risk factors') ?></button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" type="button"
                role="tab" aria-controls="faq" aria-selected="true"><?= Yii::t('db', 'FAQ') ?></button>
    </li>


</ul>
