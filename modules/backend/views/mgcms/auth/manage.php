<?php
use app\components\mgcms\MgHelpers;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Auth */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Auths');
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>Uprawnienia</h1>

<?php $form = ActiveForm::begin(); ?>


<table class="items table">
  <thead>
    <tr>
      <th>Moduł</th>
      <th>Akcja</th>
      <? foreach (MgHelpers::getConfigParam('roles') as $role): ?>
        <th><?= 'role ' . $role ?></th>
      <? endforeach ?>
    </tr>
  </thead>
  <tbody>
    <? foreach ($auths as $auth): ?>
      <tr>
        <td><?= $auth->controller ?></th>
        <td ><?= $auth->action ?></td>
        <? foreach (MgHelpers::getConfigParam('roles') as $role): ?>
          <td>
            <input type="checkbox" name="auth[<?= $auth->controller ?>][<?= $auth->action ?>][<?= $role ?>]" value="1" <?
            if ($this->context->getUserModel()->checkAccess($auth->controller, $auth->action, $role)):

              ?> checked="checked"<? endif ?>/>
          </td>

        <? endforeach ?>
      </tr>

    <? endforeach; ?>
  </tbody>
</table>

<button type="submit" class="btn-primary btn">Zapisz</button>
<?php ActiveForm::end(); ?>