<?

use app\widgets\NobleMenu;
use yii\helpers\Html;
use \app\components\mgcms\MgHelpers;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */

$isHomePage = $this->context->id == 'site' && $this->context->action->id == 'index';

$menu = new NobleMenu(['name' => 'header_' . Yii::$app->language, 'loginLink' => false]);

?>


<nav class="navbar navbar-expand-xl">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/images/logo.svg" width="250" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="<?= Yii::t('db', 'Close') ?>"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav align-items-center justify-content-end flex-grow-1 pe-3">
                    <? foreach ($menu->getItems() as $item): ?>
                        <? if (isset($item['items'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <?= $item['label'] ?>
                                    <svg class="icon">
                                        <use xlink:href="#chevron-right"/>
                                    </svg>
                                </a>
                                <ul class="dropdown-menu">
                                    <? foreach ($item['items'] as $item2): ?>
                                        <li><a class="dropdown-item"
                                               href="<?= \yii\helpers\Url::to($item2['url']) ?>"><?= $item2['label'] ?></a>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                            </li>
                        <? else: ?>
                            <li class="nav-item">
                                <? if (isset($item['url'])): ?>
                                    <a href="<?= \yii\helpers\Url::to($item['url']) ?>"
                                       class="nav-link <? if (isset($item['active']) && $item['active']): ?>active<? endif ?>"><?= $item['label'] ?></a>
                                <? endif ?>
                            </li>
                        <? endif ?>
                    <? endforeach ?>


                    <? if (Yii::$app->user->isGuest): ?>
                        <li class="nav-item">
                            <a class="btn btn-light mx-1 px-3" href="<?= Url::to('/site/login') ?>"
                              ><?= Yii::t('db', 'Login') ?></a>
                        </li>
					
                    <? else: ?>
                        <li class="nav-item">
                            <a href="<?= yii\helpers\Url::to(['/account/index']) ?>"
                               class="btn btn-light mx-1 px-3"> <?= Yii::t('db', 'My account'); ?> </a>
                        </li>
                    <? endif ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <?= strtoupper(Yii::$app->language) ?>
                            <svg class="icon">
                                <use xlink:href="#chevron-right"/>
                            </svg>
                        </a>
                        <ul class="dropdown-menu">
                            <? foreach (Yii::$app->params['languagesDisplay'] as $language) : ?>
                                <li><a class="dropdown-item"
                                       href="<?= yii\helpers\Url::to(['/', 'language' => $language]) ?>"><?= strtoupper($language) ?></a>
                                </li>
                            <? endforeach ?>

                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </div>
</nav>


<?= Html::beginForm(['/site/logout'], 'post', ['id' => 'logoutForm']) ?>
<?= Html::endForm() ?>
<script type="text/javascript">
    function submitLogoutForm() {
        $('#logoutForm').submit();
    }
</script>
