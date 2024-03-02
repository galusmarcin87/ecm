<?php
namespace app\modules\backend\controllers\mgcms;

use Yii;
use app\models\mgcms\db\Menu;
use app\models\mgcms\db\MenuSearch;
use app\models\mgcms\db\MenuItem;
use app\modules\backend\components\mgcms\MgBackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends MgBackendController
{

  private $data = array();

  public function behaviors()
  {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['post'],
                'deleteitem' => ['post'],
            ],
        ],
    ];
  }

  /**
   * Lists all Menu models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new MenuSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Menu model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    $model = $this->findModel($id);
    $providerMenuItem = new \yii\data\ArrayDataProvider([
        'allModels' => $model->children,
    ]);
    return $this->render('view', [
            'model' => $this->findModel($id),
            'providerMenuItem' => $providerMenuItem,
    ]);
  }

  /**
   * Creates a new Menu model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Menu();

    if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('create', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Updates an existing Menu model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->loadAll(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
              'model' => $model,
      ]);
    }
  }

  public function actionManage($id)
  {
    $model = $this->findModel($id);

    if (isset($_POST['article']) || isset($_POST['custom'])) {
      if (isset($_POST['article']) && $id) {
        foreach ($_POST['article'] as $articleId) {
          $menuItem = new MenuItem;
          $menuItem->menu_id = $id;
          $menuItem->article_id = $articleId;
          $menuItem->save();
        }
      }
      if (isset($_POST['category']) && $id) {
        foreach ($_POST['category'] as $catId) {
          $menuItem = new MenuItem;
          $menuItem->menu_id = $id;
          $menuItem->category_id = $catId;
          $menuItem->save();
        }
      }

      if (isset($_POST['custom']) && $_POST['custom']['label'] && $id) {
        $menuItem = new MenuItem;
        $menuItem->menu_id = $id;
        $menuItem->label = $_POST['custom']['label'];
        $menuItem->url = $_POST['custom']['url'];
        $menuItem->save();
      }
      $this->refresh();
    }
    
    $post = Yii::$app->request->post();
    if (isset($post['MenuItem'])) {
      $modelItem = MenuItem::findOne($post['MenuItem']['id']);
      $modelItem->loadAll(Yii::$app->request->post());
      $modelItem->saveAll();
    }

    $articles = \app\models\mgcms\db\Article::find()->all();


    return $this->render('manage', [
            'model' => $model,
            'articles' => $articles,
    ]);
  }

  /**
   * Deletes an existing Menu model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Menu model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Menu the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Menu::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
  }

  /**
   * Action to load a tabular form grid
   * for MenuItem
   * @author Yohanes Candrajaya <moo.tensai@gmail.com>
   * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
   *
   * @return mixed
   */
  public function actionAddMenuItem()
  {
    if (Yii::$app->request->isAjax) {
      $row = Yii::$app->request->post('MenuItem');
      if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
        $row[] = [];
      return $this->renderAjax('_formMenuItem', ['row' => $row]);
    } else {
      throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
  }

  public function actionOrder()
  {
    $result = \yii\helpers\Json::decode($_POST['order']);

    $readbleArray = $this->parseJsonArray($result);

    foreach ($readbleArray as $key => $item) {
      $menuItem = MenuItem::findOne($item['id']);
      $menuItem->order = $key;
      $menuItem->parent_id = $item['parentID'] ? $item['parentID'] : NULL;
      $menuItem->save();
    }

    var_dump($this->data);
  }

  private function parseJsonArray($jsonArray, $parentID = 0)
  {
    $return = array();
    foreach ($jsonArray as $subArray) {
      $returnSubSubArray = array();
      if (isset($subArray['children'])) {
        $returnSubSubArray = $this->parseJsonArray($subArray['children'], $subArray['id']);
      }
      $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
      $return = array_merge($return, $returnSubSubArray);
    }

    return $return;
  }

  public function actionDeleteitem()
  {
    MenuItem::findOne($_POST['id'])->delete();
  }
}
