<?
/* @var $model app\models\mgcms\db\Product */

/* @var $this View */

use yii\web\View;
use \app\models\mgcms\db\Category;
use yii\widgets\ListView;

?>
<section class="companies-wrapper">
    <div class="container">
        <h1 class="text-left"><?= Yii::t('db', 'Search results') ?></h1>
        <div class="search-results">
            <?= $this->render('/common/leftMenu') ?>

            <div>
            <?= $this->render('_searchResultsType',['header' => 'Companies','provider' => $companyDataProvider,'itemView'=>'/company/_index'])?>

            <?= $this->render('_searchResultsType',['header' => 'Products','provider' => $productDataProvider,'itemView'=>'/product/_index'])?>

            <?= $this->render('_searchResultsType',['header' => 'Services','provider' => $serviceDataProvider,'itemView'=>'/service/_index'])?>

            <?= $this->render('_searchResultsType',['header' => 'Job obbers','provider' => $jobDataProvider,'itemView'=>'/job/_index'])?>
            </div>
        </div>
</section>
