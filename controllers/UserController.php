<?php

namespace wma\controllers;

use Yii;
use wma\controllers\Controller;
use wma\models\LoginForm;
use wma\models\RegisterForm;
use wma\models\ForgotPasswordForm;
use wma\models\ForgotUsernameForm;
use wma\models\User;

class UserController extends Controller
{
    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    public $layout = '@wma/views/layouts/login';

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
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

    public function actionForgotPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ForgotPasswordForm();
        if ($model->load(Yii::$app->request->post())) {
            // handle form
        }
        return $this->render('forgot-password', [
                'model' => $model,
            ]);
    }

    public function actionForgotUsername()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ForgotUsernameForm();
        if ($model->load(Yii::$app->request->post())) {
            // handle form
        }
        return $this->render('forgot-username', [
                'model' => $model,
            ]);
    }

    public function actionRegister() {
        if (   !Yii::$app->user->isGuest
            || Yii::$app->getAdminModule()->getOption('userRegister', 'webRegistration') !== true
        ) {
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
        Yii::$app->session->setFlash('logout', ['heading' => 'Successfully Logged Out','message' => 'User session cleared.', 'icon' => 'sign-out']);
        return $this->redirect(['/' . Yii::$app->adminModuleId . '/user/login']);
    }
}
