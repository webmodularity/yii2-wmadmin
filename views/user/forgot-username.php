<?php

use wma\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Recover Username';
$form = ActiveForm::begin([
        'options' => ['class' => 'smart-form client-form'],
        'validateOnSubmit' => false
    ]) ?>
    <header>
        <?= $this->title ?>
    </header>

    <fieldset>
        <?= $form->field($model, 'email')->label('Email Address')->iconAppend('envelope')->hint('Enter your email address and your username will be sent via email.') ?>
    </fieldset>

    <footer>
        <?= Html::submitButton($this->title , ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end() ?>