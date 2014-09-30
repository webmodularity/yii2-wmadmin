<?php

namespace wma\controllers;

use Yii;
use wma\controllers\Controller;
use wma\models\LoginForm;
use wma\models\RegisterForm;
use wma\models\User;

class UserController extends Controller
{
    public $layout = '@wma/views/layouts/login';


    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                    'model' => $model,
                ]);
        }
    }

    public function actionRegister() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->registerUser()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('register', [
                'model' => $model
            ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
