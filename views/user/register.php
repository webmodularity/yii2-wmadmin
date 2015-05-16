<?php

use wma\widgets\ActiveForm;
use wmc\helpers\Html;

$this->title = 'Register';
$form = ActiveForm::begin([
        'options' => ['class' => 'client-form']
    ]) ?>
    <header>
        Register New Account
    </header>

    <fieldset>
        <div class="row">
            <?= $form->field($model, 'first_name')->placeholder()->colspan(6)->iconAppend('user') ?>
            <?= $form->field($model, 'last_name')->placeholder()->colspan(6)->iconAppend('user') ?>
        </div>
        <?= $form->field($model, 'email')->placeholder()->iconAppend('envelope') ?>
        <div class="row">
            <?= $form->field($model, 'password')->placeholder()->passwordInput()->colspan(6)->iconAppend('lock') ?>
            <?= $form->field($model, 'password_confirm')->placeholder()->passwordInput()->colspan(6)->iconAppend('lock') ?>
        </div>
        <?= $form->field($model, 'captcha')->widget('wmc\modules\recaptcha\widgets\Recaptcha')->label(false); ?>
    </fieldset>

    <footer>
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end() ?>