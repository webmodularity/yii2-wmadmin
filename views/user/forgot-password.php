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
            <?= $form->field($model, 'username')->label()->iconAppend('user') ?>
        </section>
        <section>
            <span class="timeline-seperator text-center text-primary"> <span class="font-sm">OR</span>
        </section>
        <section>
            <?= $form->field($model, 'email')->label()->iconAppend('envelope')->hint('Enter your username <strong>or</strong> email address and a password reset link will be sent via email.') ?>
        </section>
    </fieldset>

    <footer>
        <?= Html::submitButton($this->title , ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end() ?>