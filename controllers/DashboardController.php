<?php

namespace wma\controllers;

use yii\filters\AccessControl;

class DashboardController extends \wma\controllers\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('@wma/views/dashboard/index');
    }

    public function actionGo() {
        return $this->redirect(['/dashboard/index']);
    }

    public function actionAjax() {
        return $this->renderAjax('@wma/views/dashboard/random', ['random' => rand(1,100)]);
    }

}