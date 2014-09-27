<?php

use wma\widgets\ActiveForm;
use wmc\helpers\Html;

$this->title = 'Login';
$form = ActiveForm::begin([
        'options' => ['class' => 'smart-form client-form']
    ]) ?>
    <header>
        Sign In
    </header>

    <fieldset>
        <?= $form->field($model, 'username')->iconAppend('user') ?>
        <?= $form->field($model, 'password')->passwordInput()->iconAppend('lock')->hint(Html::a('Forgot password?', 'forgot-password')) ?>
        <?= $form->field($model, 'rememberMe')->checkbox()->label(false) ?>
    </fieldset>

    <footer>
        <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end() ?>