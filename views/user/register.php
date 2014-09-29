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
            <?= $form->field($model, 'first_name')->placeholder()->colspan(6)->iconAppend('user')->label('Your Info') ?>
            <?= $form->field($model, 'last_name')->placeholder()->colspan(6)->iconAppend('user')->label('&nbsp;') ?>
        </div>
        <?= $form->field($model, 'email')->placeholder()->iconAppend('envelope') ?>
    </fieldset>
    <fieldset>
        <?= $form->field($model, 'username')->placeholder('Desired Username')->iconAppend('user')->label('Login Info') ?>
        <div class="row">
            <?= $form->field($model, 'password')->placeholder()->passwordInput()->colspan(6)->iconAppend('lock') ?>
            <?= $form->field($model, 'password_confirm')->placeholder()->passwordInput()->colspan(6)->iconAppend('lock') ?>
        </div>
    </fieldset>

    <footer>
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end() ?>