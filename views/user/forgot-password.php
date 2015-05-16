<?php

use wma\widgets\ActiveForm;
use wmc\helpers\Html;

$this->title = 'Reset Password';
$form = ActiveForm::begin([
        'options' => ['class' => 'client-form']
    ]) ?>
    <header>
        <?= $this->title ?>
    </header>

    <fieldset>
        <section>
            <?= $form->field($model, 'email')->placeholder()->iconAppend('envelope')->hint('Enter your email address and a password reset link will be sent via email.') ?>
        </section>
    </fieldset>

    <footer>
        <?= Html::submitButton($this->title , ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end() ?>