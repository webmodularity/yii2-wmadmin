<?php

namespace wma\controllers;

use Yii;
use wma\models\LogBackend;
use wma\models\LogBackendSearch;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogBackendController extends Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
            [
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
                    ]
            ]
        );
    }

    /**
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogBackendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@wma/views/log-backend/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Log model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('@wma/views/log-backend/view', [
            'model' => $model
        ]);
    }

    /**
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogBackend::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}