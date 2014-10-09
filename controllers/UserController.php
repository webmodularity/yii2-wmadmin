<?php

namespace wma\controllers;

use Yii;
use yii\helpers\Html;
use wma\controllers\Controller;
use wmc\models\LoginForm;
use wmc\models\RegisterForm;
use wmc\models\ForgotPasswordForm;
use wmc\models\ForgotUsernameForm;
use wmc\models\User;
use wmc\models\UserKey;

class UserController extends Controller
{
    public $layout = '@wma/views/layouts/login';

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm([
                'sessionDuration' => Yii::$app->adminModule->getOption('user', 'sessionDuration')
            ]);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                    'model' => $model,
                ]);
        }
    }

    public function actionForgotPassword() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ForgotPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = !$model->email ? User::findByUsername($model->username) : User::findByEmail($model->email);
            if (!is_null($user)) {
                $key = UserKey::getKey($user->person_id, 'reset-password', Yii::$app->request->getUserIP());
                Yii::$app->alertManager->addSuccess(
                    'An email has been sent to the registered email address with instructions on how to reset
                     your password. Further action is required, check your email.',
                    'Password Reset Request Sent',
                    ['icon' => 'hand-o-right']
                );
            } else {
                Yii::$app->alertManager->addDanger(
                    'Failed to send password reset request, unable to locate user.',
                    'No Account Found',
                    ['icon' => 'ban']
                );
            }

            return Yii::$app->response->refresh();
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
        Yii::$app->alertManager->addSuccess('User session cleared.', 'Successfully Logged Out', ['icon' => 'sign-out']);
        return Yii::$app->getResponse()->redirect(Yii::$app->user->loginUrl);
    }
}
