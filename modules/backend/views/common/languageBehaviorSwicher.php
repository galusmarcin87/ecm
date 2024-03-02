<?
use app\components\mgcms\MgHelpers;

?>

<? if (!$model->isNewRecord): ?>
  <div class="col-md-12">
      <div class="well ">
          <div class="row">
              <?= $form->field12md($model, 'language')->languageDropdown(); ?>
          </div>
      </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function () {
        $('#<?= strtolower(MgHelpers::getClassShortName($model))?>-language').change(function () {
            window.location.href = '/backend/mgcms/<?= MgHelpers::convertCamelCaseToMinusCase(MgHelpers::getClassShortName($model))?>/update?id=<?= $model->id ?>&lang=' + $(this).val();
        });
    });
  </script>
  <?
 endif ?>