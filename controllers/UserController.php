<?php

namespace wma\controllers;

use Yii;
use yii\helpers\Html;
use wmc\models\user\User;
use wmc\models\user\UserKey;
use wmc\models\user\UserLog;

class UserController extends \wmc\controllers\UserController
{

    public $layout = '@wma/views/layouts/login';

    public $viewFile = [
        'login' => '@wma/views/user/login',
        'forgotPassword' => '@wma/views/user/forgot-password',
        'resetPassword' => '@wma/views/user/reset-password',
        'register' => '@wma/views/user/register',
        'error' => '@wma/views/user/error'
    ];

    public $emailData = [
        'confirm-email' => [
            'title' => "Confirm Email",
            'subject' => "User Email Confirmation"
        ]
    ];

    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $statusCode = isset($exception->statusCode) ? $exception->statusCode : '';
            return $this->render($this->viewFile['error'], ['exception' => $exception, 'statusCode' => $statusCode]);
        }
    }

    public function actionRegister() {
        $model = new User([
            'scenario' => 'registerEmail',
            'group_id' => Yii::$app->adminSettings->getOption('user.register.newUserRole'),
            'status' => Yii::$app->adminSettings->getOption('user.register.newUserStatus')
            ]);
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        } else if (Yii::$app->adminSettings->getOption('user.register.webRegistration') !== true) {
            Yii::error("User registration attempted without user.register.webRegistration being set to true!", 'user');
            throw new \yii\web\HttpException(404, 'Registration is not allowed.');
        }  else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->adminSettings->getOption('user.register.confirmEmail') === true) {
                $userKey = UserKey::generateKey($model->id, UserKey::TYPE_CONFIRM_EMAIL);
                $this->sendConfirmEmail($model->email, $userKey->user_key);
            }

            // Simply attempts to log new user in
            if (Yii::$app->getUser()->login($model)) {
                UserLog::add(UserLog::ACTION_LOGIN, UserLog::RESULT_SUCCESS);
                return $this->goHome();
            }
        }

        return $this->render($this->viewFile['register'], ['model' => $model]);
    }
/*
    public function actionConfirm($key) {
        throw new ForbiddenHttpException('Down for maintenance');
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        } else if (Yii::$app->adminSettings->getOption('user.register.webRegistration') !== true
            || Yii::$app->adminSettings->getOption('user.register.confirmEmail') !== true
            || !$key || !is_string($key) || strlen($key) != 32
        ) {
            throw new \yii\web\HttpException(404, 'Invalid parameters passed to confirm email page.');
        } else if (UserCooldown::IPOnCooldown(Yii::$app->request->userIP) === true) {
            // IP is on cooldown
            static::addCooldownAlert();
            return Yii::$app->response->redirect(Yii::$app->user->loginUrl);
        }

        $userKey = UserKey::findByKey($key, UserKey::TYPE_CONFIRM_EMAIL);
        if (is_null($userKey)) {
            // See if we can find key but it's expired
            $expiredKey = UserKey::fndByKey($key, UserKey::TYPE_CONFIRM_EMAIL, true);
            if (!is_null($expiredKey)) {
                // The key exists but has expired, generate new key and send email
                UserCooldownLog::add(UserCooldownLog::ACTION_CONFIRM_EMAIL_EXPIRED_KEY);
                Yii::$app->alertManager->add(
                    'warning',
                    'This confirmation key has expired. A new confirmation link has been sent to you via email. '
                    . 'Please follow the confirmation instructions in that email to continue.',
                    'Expired User Key!'
                );
            } else {
                UserCooldownLog::add(UserCooldownLog::ACTION_CONFIRM_EMAIL_BAD_KEY);
                Yii::$app->alertManager->add(
                    'danger',
                    'Cannot confirm email address as the specified user key could not be located in our database.',
                    'Unrecognized User Key!',
                    ['icon' => 'ban']
                );
            }
        }
    }
*/

    protected function sendConfirmEmail($to, $key) {
        $params =
            [
                'key' => $key,
                'title' => $this->emailData['confirm-email']['title'],
                'emailAddress' => $to
            ];
        Yii::$app->mailer->compose('@wma/mail/confirm-email', $params)
            ->setFrom(Yii::$app->params['noReplyEmail'])
            ->setTo($to)
            ->setSubject($this->emailData['confirm-email']['subject'])
            ->send();
    }

}
