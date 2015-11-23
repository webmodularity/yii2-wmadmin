<?php

use wma\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Forgot Password'; ?>
<p class="login-box-msg">Enter your email address and a password reset link will be sent via email.</p>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'email')->placeholder()->feedbackIcon('envelope')->label(false) ?>

    <div class="row">
        <div class="col-xs-6">
            <?= Html::a('User Login', 'login') ?>
        </div>
        <div class="col-xs-6">
            <?= Html::submitButton('Reset Password' , ['class' => 'btn btn-primary btn-block btn-flat']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>