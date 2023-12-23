<?

use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */

$images = ['/images/icons/hand.svg', '/images/icons/clock.svg', '/images/icons/blockchain.svg', '/images/icons/planet-earth.svg'];
?>

<div class="container py-5">
    <div class="bg-light-right">
        <div class="bg-light-right-content">


            <div class="advantages">
                <? foreach ($model->bonuses as $i => $bonus): ?>
                    <div class="advantages-item">
                        <? if (isset($images[$i])): ?>
                            <div class="advantages-icon">
                                <img src="<?= $images[$i] ?>" alt="">
                            </div>
                        <? endif; ?>
                        <div class="advantages-title text-uppercase">
                            <p><?= $bonus->from ?></p>
                            <h3><?= $bonus->value ?></h3>

                        </div>
                    </div>
                <? endforeach; ?>


            </div>


        </div>
    </div>
</div>
