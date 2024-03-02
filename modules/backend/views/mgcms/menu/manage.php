<?php
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('app', 'Manage Menu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Menu */
/* @var $form app\components\mgcms\yii\ActiveForm */

$this->registerJsFile('@web/js/jquery.nestable.js');
$this->registerCssFile('@web/css/nestable.css');

?>

<?php $form = ActiveForm::begin(); ?>
<div class = "row">
  <div class = "col-md-7">
    <?
    echo yii\bootstrap\Collapse::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'Articles'),
                'content' => \yii\bootstrap\Html::checkboxList('article', '', \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Article::find()->orderBy('title')->asArray()->all(), 'id', 'title')),
            ],
             [
                'label' => Yii::t('app', 'Categories'),
                'content' => \yii\bootstrap\Html::checkboxList('category', '', \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Category::find()->orderBy('name')->asArray()->all(), 'id', 'name')),
            ],
        ]
    ]);
    ?>
  </div>


  <div class="col-md-5">
    <div class="well">
      <h2><?= Yii::t('app', 'Custom link') ?></h2>
      <div class="own">
        <div class="form-group">
          <?php echo Html::label(Yii::t('app', 'Label'), 'label', ['class' => 'control-label']); ?>
          <?php echo Html::textInput('custom[label]', '', ['class' => 'form-control']); ?>
          <div class="help-block"></div>
        </div>
        <div class="form-group">
          <?php echo Html::label(Yii::t('app', 'URL'), 'url', ['class' => 'control-label']); ?>
          <?php echo Html::textInput('custom[url]', '', ['class' => 'form-control']); ?>
          <div class="help-block"></div>
        </div>        
      </div>
    </div>
  </div>      
</div>


<?= Html::button(Yii::t('app', 'Add link'), ['class' => 'btn btn-primary', 'type' => 'submit']) ?>
<?php ActiveForm::end(); ?>

<div class="row-fluid dd" id="menuNestable">
  <?php echo $this->render('_submenu', array('items' => $model->children)); ?>
</div>



<script type="text/javascript">
  $(document).ready(function () {
    jQuery('.delete').on('click', function (event) {
      event.preventDefault();

      if (confirm('Czy na pewno usunąć')) {
        id = $(this).closest('li.dd-item');
        console.log(id.find('ol.dd-list').length);
        if (id.find('ol.dd-list').length = 0) {
          alert('Możesz usunąć tylko ostatni element');
        } else {
          jQuery.ajax({
            url: '<?= MgHelpers::createUrl("/backend/mgcms/menu/deleteitem") ?>',
            data: {'id': id.data('id'), _csrf: yii.getCsrfToken()},
            type: 'post',
            success: function (data) {
              id.remove();
            }
          });
        }
      }


      jQuery('.seo').each(function (index, item) {
        name = jQuery(this).attr('name');
        value = item.value;
      });
    });


    $('#menuNestable').nestable('collapseAll').on('change', function (e)
    {
      var list = e.length ? e : $(e.target),
              output = list.data('output');

      $.ajax({
        url: '<?= MgHelpers::createUrl('/backend/mgcms/menu/order') ?>',
        type: 'post',
        data: {'id': $(this).attr('id'), 'order': window.JSON.stringify(list.nestable('serialize'))},
        success: function (data) {

        }
      });
    });
  });

</script>