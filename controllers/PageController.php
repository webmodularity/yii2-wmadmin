<?php

namespace wma\controllers;

use Yii;
use wmf\models\Page;
use wmf\models\PageMarkdown;
use wmf\models\PageSearch;
use yii\helpers\Markdown;
use yii\base\InvalidCallException;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use wma\widgets\Alert;
use wma\models\PageMenuIntegrationForm;

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
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $page = new Page();
        $pageMarkdown = new PageMarkdown();
        $pageMenuIntegration = new PageMenuIntegrationForm(['active' => 0]);

        if ($pageMarkdown->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post()) && $pageMarkdown->validate() && $page->validate()) {
            $page->html = Markdown::process($pageMarkdown->markdown, 'gfm');
            if ($page->save(false)) {
                $pageMarkdown->page_id = $page->id;
                if ($pageMarkdown->save(false)) {
                    Yii::$app->alertManager->add(Alert::widget(
                        [
                            'heading' => "Page Created!",
                            'message' => "Successfully created page.",
                            'style' => 'success',
                            'block' => true,
                            'icon' => 'check-square-o'
                        ]));
                    return $this->redirect(['update', 'id' => $page->id]);
                }
            }
        }
        return $this->render('@wma/views/page/create', [
            'page' => $page,
            'pageMarkdown' => $pageMarkdown,
            'pageMenuIntegration' => $pageMenuIntegration
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
        $pageMarkdown = $page->latestMarkdown;
        $pageMenuIntegration = new PageMenuIntegrationForm(['active' => 0]);

        if ($pageMarkdown->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post()) && $pageMarkdown->validate() && $page->save()) {
            if (in_array('markdown', array_keys($pageMarkdown->getDirtyAttributes(['markdown'])))) {
                $newMarkdown = new PageMarkdown();
                $newMarkdown->page_id = $page->id;
                $newMarkdown->page_version = $pageMarkdown->page_version + 1;
                $newMarkdown->markdown = $pageMarkdown->markdown;
                if (!$newMarkdown->save()) {
                    Yii::error("Failed to save markdown for page! Error: " . VarDumper::dumpAsString($newMarkdown->getErrors()));
                    throw new InvalidCallException("Unable to update page content!");
                }
                $page->html = Markdown::process($pageMarkdown->markdown, 'gfm');
            }
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Page Updated!",
                    'message' => "Successfully updated page.",
                    'style' => 'success',
                    'block' => true,
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        } else {
            return $this->render('@wma/views/page/update', [
                'page' => $page,
                'pageMarkdown' => $pageMarkdown,
                'pageMenuIntegration' => $pageMenuIntegration
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