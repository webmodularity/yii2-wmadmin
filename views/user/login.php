<?php

use wma\widgets\ActiveForm;
use yii\helpers\Html;

$registerLink = Yii::$app->adminSettings->getOption('user.register.webRegistration') ? '<br />' . Html::a('Register New Account', ['register']) : '';

$this->title = 'Login'; ?>
    <p class="login-box-msg">All CMS User Sessions are Logged.</p>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'email', ['inputOptions' => ['tabindex' => 1, 'autofocus' => 'autofocus']])->feedbackIcon('envelope')->placeholder('Email')->input('email')->label(false); ?>
<?= $form->field($model, 'password', ['inputOptions' => ['tabindex' => 2]])->feedbackIcon('lock')->placeholder('Password')->passwordInput()->label(false); ?>

    <div class="row">
        <div class="col-xs-6">
            <?= Html::a('Forgot password?', 'forgot-password') . $registerLink ?>
        </div>
        <div class="col-xs-6">
            <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block btn-flat', 'tabindex' => 3]) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>