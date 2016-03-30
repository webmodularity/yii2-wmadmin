<?php

namespace wma\controllers;

use Yii;
use wmc\models\FilePath;
use wma\models\FilePathSearch;
use wma\controllers\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use wma\widgets\Alert;

/**
 * FilePathController implements the CRUD actions for FilePath model.
 */
class FilePathController extends Controller
{
    public function behaviors()
    {
        return [
            'access' =>
                [
                    'class' => \yii\filters\AccessControl::className(),
                    'rules' =>
                        [
                            [
                                'allow' => true,
                                'roles' => ['su'],
                            ]
                        ]
                ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all FilePath models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FilePathSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@wma/views/file-path/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new FilePath model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FilePath(['path' => '@frontend/uploads']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "File Path Added.",
                    'message' => "Successfully added a new File Path.",
                    'style' => 'success',
                    'encode' => false,
                    'icon' => 'check-square-o'
                ]));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('@wma/views/file-path/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FilePath model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "File Path Updated!",
                    'message' => "Successfully updated record.",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        } else {
            return $this->render('@wma/views/file-path/update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FilePath model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->findModel($id)->delete() === false) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'Delete File Path Failed!',
                    'message' => "The File Path could not be deleted, the server encountered an error:",
                    'style' => 'danger',
                    'icon' => 'times-circle-o'
                ]));
        } else {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'File Path Deleted!',
                    'message' => "The File Path has been deleted. Record successfully removed from database.",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the FilePath model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FilePath the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FilePath::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}