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
<?= $this->render('_svg') ?>

        <nav class="navbar navbar-expand-xl">
    <div class="container">
      <a class="navbar-brand" href="/">
        <img src="assets/images/logo.svg" width="250" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
          <ul class="navbar-nav align-items-center justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/art/o-nas">O nas</a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Tokeny
                <svg class="icon">
                  <use xlink:href="#chevron-right" />
                </svg>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/projekt-ecm.html">Energetyka przyszłości ECM</a></li>
                <li><a class="dropdown-item" href="/projekty-sdt.html">Seria SDT</a></li>
                <li><a class="dropdown-item" href="/projekt-ec.html">Energy Coin (EC)</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/site/invest">Zainwestuj</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/media.html">Media o nas</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/art/kariera">Kariera</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/faq/index?id=1">FAQ</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/kontakt">Kontakt</a>
            </li>

            <li class="nav-item">
              <a class="btn btn-light mx-1 px-3" href="<?= Url::to('/site/login') ?>" class="nav-link"><?= Yii::t('db', 'Login') ?></a>
            </li>

            <li class="nav-item">
              <a class="btn btn-light mx-1 px-3" href="<?= Url::to('/site/register') ?>" class="nav-link"><?= Yii::t('db', 'Register') ?></a>
            </li>

             <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                EN
                <svg class="icon">
                  <use xlink:href="#chevron-right" />
                </svg>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">PL</a></li>
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
