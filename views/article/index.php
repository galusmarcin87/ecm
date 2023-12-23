<?php
/* @var $this yii\web\View */
// Aktualnosci lista
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\widgets\ListView;

$this->title = Yii::t('db', 'News');
if (isset($tag) && $tag) {
    $this->title = Yii::t('db', 'Tag') . ' - ' . $tag;
}


$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});";
$this->registerJs($search);

?>

<div class="page-header-text ">
    <div class="page-header-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
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
    </div>
</div>


<div class="posts-section py-5 my-5">

    <div class="section-background">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC aaa
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div><div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div><div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div><div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div><div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div><div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div><div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div><div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div><div class="col-lg-4">
                        <a class="card card-light mb-3" href="posts-item.html">
                            <div class="card-main-image img-corner-left-top">
                                <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
                                <div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
                                <h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
                            </div>
                            </a>
                    </div>
            </div>

            <nav aria-label="Page navigation">
<?=
            ListView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{pager}',
                'options' => [
                    'class' => 'Page navigation',
                    'tag' => 'nav'
                ],
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center'],
                    'firstPageLabel' => false,
                    'lastPageLabel' => false,
                    'prevPageLabel' => '<svg class="icon">
                            <use xlink:href="#long-left-arrow"></use>
                        </svg>',
                    'nextPageLabel' => '<svg class="icon">
                            <use xlink:href="#long-right-arrow"/>
                        </svg>',
                    // Customzing CSS class for pager link
                    'linkOptions' => [
                        'class' => 'page-link'
                    ],
                    'activePageCssClass' => 'active',
                    'pageCssClass' => 'page-item',
                    // Customzing CSS class for navigating link
                    'prevPageCssClass' => 'page-item prev',
                    'nextPageCssClass' => 'page-item next',
                    'firstPageCssClass' => 'page-item first',
                    'lastPageCssClass' => 'page-item page-last',
                ],
            ])

            ?>
</nav>
            

        </div>
    </div>
</div>


