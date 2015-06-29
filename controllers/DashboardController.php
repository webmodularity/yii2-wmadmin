<?php

namespace wma\controllers;

use yii\filters\AccessControl;

class DashboardController extends \wma\controllers\Controller
{

    public function actionIndex()
    {
        return $this->render('@wma/views/dashboard/index');
    }

    public function actionGo() {
        return $this->redirect(['/dashboard/index']);
    }

}