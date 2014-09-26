<?php

use wmadmin\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Register';
$form = ActiveForm::begin([
        'options' => ['class' => 'smart-form client-form']
    ]) ?>
    <header>
        Register New Account
    </header>

    <fieldset>
        <div class="row">
            <?= $form->field($person, 'first_name')->placeholder()->colspan(6)->iconAppend('user') ?>
            <?= $form->field($person, 'last_name')->placeholder()->colspan(6)->iconAppend('user') ?>
        </div>

        <?= $form->field($person, 'email')->placeholder()->iconAppend('envelope') ?>
        <?= $form->field($user, 'username')->placeholder()->iconAppend('user') ?>

        <div class="row">
            <?= $form->field($user, 'password_hash')->placeholder()->passwordInput()->colspan(6)->iconAppend('lock') ?>
            <?= $form->field($user, 'password_confirm')->placeholder()->passwordInput()->colspan(6)->iconAppend('lock') ?>
        </div>
    </fieldset>

    <footer>
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end() ?>