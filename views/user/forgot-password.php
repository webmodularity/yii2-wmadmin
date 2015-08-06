<?php

use wma\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Forgot Password';
$form = ActiveForm::begin([
        'options' => ['class' => 'smart-form client-form']
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