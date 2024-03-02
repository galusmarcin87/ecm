<?

use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */

?>
<aside class="project-details">

    <?= $this->render('/project/_yearAndPercentage', ['model' => $model, 'cssPrefixClass' => 'project']) ?>

    <?= $this->render('/project/_counterTimer', ['model' => $model]) ?>

    <?= $this->render('/project/_counterMoney', ['model' => $model, 'cssClass' => 'project-progress']) ?>

</aside>
