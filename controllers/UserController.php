<?php

namespace wma\controllers;

use Yii;

class UserController extends \wmu\controllers\BackendUserController
{
    public $layout = '@wma/views/layouts/login';

    public $viewFileLogin = '@wma/views/user/login';
    public $viewFileForgotPassword = '@wma/views/user/forgot-password';
    public $viewFileForgotUsername = '@wma/views/user/forgot-username';
    public $viewFileRegister = '@wma/views/user/register';

    public function actionRegister() {
        if (Yii::$app->adminSettings->getOption('user.register.webRegistration') !== true) {
            return $this->goHome();
        }
        return parent::actionRegister();
    }

}
