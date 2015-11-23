<?php

use wma\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Register'; ?>
    <p class="login-box-msg">Register New Account</p>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model->person, 'first_name')->placeholder()->feedbackIcon('user')->label(false) ?>
    <?= $form->field($model->person, 'last_name')->placeholder()->feedbackIcon('user')->label(false) ?>
    <?= $form->field($model, 'email')->placeholder()->feedbackIcon('envelope')->label(false) ?>
    <?= $form->field($model, 'password')->placeholder()->passwordInput()->colspan(6)->feedbackIcon('lock')->label(false) ?>
    <?= $form->field($model, 'password_confirm')->placeholder()->passwordInput()->colspan(6)->feedbackIcon('lock')->label(false) ?>
    <?= $form->field($model, 'captcha')->widget('wmc\modules\recaptcha\widgets\Recaptcha')->label(false); ?>

    <div class="row">
        <div class="col-xs-6">
            <?= Html::a('User Login', 'login') ?>
        </div>
        <div class="col-xs-6">
            <?= Html::submitButton('Register' , ['class' => 'btn btn-primary btn-block btn-flat']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>