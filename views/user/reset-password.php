<?php

use wma\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Reset Password';
$form = ActiveForm::begin([
    'options' => ['class' => 'smart-form client-form']
]) ?>
    <header>
        <?= $this->title ?>
    </header>

    <fieldset>
        <section>
            <?= $form->field($model, 'password')->passwordInput()->label('New Password')->iconAppend('lock') ?>
        </section>
        <section>
            <?= $form->field($model, 'password_confirm')->passwordInput()->label('Confirm New Password')->iconAppend('lock') ?>
        </section>
    </fieldset>

    <footer>
        <?= Html::submitButton($this->title , ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end() ?>