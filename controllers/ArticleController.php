<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use \app\models\mgcms\db\Article;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use \app\models\mgcms\db\Tag;

class ArticleController extends \app\components\mgcms\MgCmsController
{

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\HttpCache',
                'only' => ['index', 'view'],
//            'lastModified' => function ($action, $params) {
////              return '2018-05-02 19:28:10';
//            },
//            'cacheControlHeader' => 'public, max-age=3600'
            ],
        ];
    }

    public function actionIndex($catSlug = false)
    {
//    Yii::$app->response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60)));
        $categoryId = null;
        $category = null;

        if ($catSlug) {
            $category = \app\models\mgcms\db\Category::findByUrl($catSlug);
            if ($category) {
                $categoryId = $category->id;
            }
        }
        $dataProvider = new ActiveDataProvider([
            //'pagination' => ['pageSize' => '2'],
            'query' => Article::find()->where($categoryId ? ['category_id' => $categoryId] : [])
                ->andWhere(['status' => Article::STATUS_ACTIVE, 'type' => Article::TYPE_NEWS])
                ->orderBy('order ASC , created_on DESC'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'category' => $category
        ]);
    }

    public function actionCategory($categorySlug = false)
    {
        return $this->actionIndex($categorySlug);
    }

    public function actionTag($tagSlug = false)
    {
        $tag = Tag::findOne(['slug' => $tagSlug]);
        if (!$tag) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Not found'));
        }
        $query = Article::find()->joinWith('tags')
            ->where(['tag.slug' => $tagSlug, 'status' => Article::STATUS_ACTIVE])
            ->orderBy('article.created_on DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'tag' => $tag
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionView($slug, $categorySlug = false)
    {
        \mgcms\lightbox\Lightbox::widget();
        $article = Article::find()->where(['slug' => $slug])->andWhere(['!=', 'status', Article::STATUS_INACTIVE])->one();
        if (!$article) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }

        /* -----------  SEO  ------------ */
        Yii::$app->view->title = $article->meta_title ? $article->meta_title : $article->title;
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $article->meta_description
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $article->meta_keywords
        ]);
        /* -----------  SEO  ------------ */
        $isNewsSite = $article->category && $article->category->name == 'aktualności ' . Yii::$app->language;

        return $this->render($article->type == Article::TYPE_GALLERY ? 'viewGallery' : 'view' . ($isNewsSite ? '' : ''), ['model' => $article]);
    }
}
