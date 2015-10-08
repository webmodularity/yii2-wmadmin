<?php

namespace wma\controllers;

use Yii;
use wmf\models\Page;
use wmf\models\PageMarkdown;
use wmf\models\PageSearch;
use wma\controllers\Controller;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@wma/views/page/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $page = new Page();
        $pageMarkdown = new PageMarkdown();

        if ($pageMarkdown->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post()) && $pageMarkdown->validate() && $page->validate()) {
            $page->html = \yii\helpers\Markdown::process($pageMarkdown->markdown);
            if ($page->save(false)) {
                $pageMarkdown->page_id = $page->id;
                if ($pageMarkdown->save(false)) {
                    return $this->redirect(['update', 'id' => $page->id]);
                }
            }
        }
        return $this->render('@wma/views/page/create', [
            'page' => $page,
            'pageMarkdown' => $pageMarkdown
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $page = $this->findModel($id);
        $pageMarkdown = $page->pageMarkdown[0];

        if ($pageMarkdown->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post()) && $pageMarkdown->validate() && $page->validate()) {
            die('updating');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('@wma/views/page/update', [
                'page' => $page,
                'pageMarkdown' => $pageMarkdown
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
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
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}