<?php

namespace wma\controllers;

use wmc\models\user\User;

class DashboardController extends \wma\controllers\Controller
{

    public function actionIndex()
    {

        return $this->render('@wma/views/dashboard/index',[
            'activeUsers' => User::find()->active()->count(),
            'pendingUsers' => User::find()->pending()->count()
        ]);
    }

    public function actionGo() {
        return $this->redirect(['/dashboard/index']);
    }

}