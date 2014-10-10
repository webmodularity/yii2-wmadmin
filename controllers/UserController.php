<?php

namespace wma\controllers;

use Yii;
use wmc\helpers\Html;
use wmc\models\LoginForm;
use wmc\models\RegisterForm;
use wmc\models\ForgotPasswordForm;
use wmc\models\ForgotUsernameForm;
use wmc\models\User;
use wmc\models\UserKey;

class UserController extends \wma\controllers\Controller
{
    public $layout = '@wma/views/layouts/login';

    public function actionError() {
        Yii::$app->alertManager->addDanger(
            Yii::$app->errorHandler->exception->getMessage(),
            Yii::$app->errorHandler->exception->getName(),
            ['block' => true]
        );
        $this->redirect(['/user/login']);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            die(var_dump(Yii::$app->getUser()));
            return $this->goHome();
        }
        $model = new LoginForm([
                'sessionDuration' => Yii::$app->adminSettings->getOption('user.sessionDuration')
            ]);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('@wma/views/user/login', [
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
        return $this->render('@wma/views/user/forgot-password', [
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
        return $this->render('@wma/views/user/forgot-username', [
                'model' => $model,
            ]);
    }

    public function actionRegister() {
        if (   !Yii::$app->user->isGuest
            || Yii::$app->adminSettings->getOption('user.register.webRegistration') !== true
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

        return $this->render('@wma/views/user/register', [
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
