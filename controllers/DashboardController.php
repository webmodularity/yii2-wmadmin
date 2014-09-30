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
        return $this->render('index');
    }

    public function actionGo() {
        return $this->redirect(['dashboard/index']);
    }

}