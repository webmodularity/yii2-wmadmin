<?php

use wma\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Reset Password'; ?>
    <p class="login-box-msg">Reset your password below.</p>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'password')->passwordInput()->label('New Password')->feedbackIcon('lock') ?>
<?= $form->field($model, 'password_confirm')->passwordInput()->label('Confirm New Password')->feedbackIcon('lock') ?>

    <div class="row">
        <div class="col-xs-6">
            <?= Html::a('User Login', 'login') ?>
        </div>
        <div class="col-xs-6">
            <?= Html::submitButton('Reset Password' , ['class' => 'btn btn-primary btn-block btn-flat']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>