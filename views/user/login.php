<?php

use wma\widgets\ActiveForm;
use wma\helpers\Html;

$this->title = 'Login';
$form = ActiveForm::begin([
        'options' => ['class' => 'smart-form client-form']
    ]) ?>
    <header>
        Sign In
    </header>

    <fieldset>
        <?php
        echo $form->field(
            $model,
            'email',
            [
                'inputOptions' => [
                    'tabindex' => 1,
                    'autofocus' => 'autofocus'
                ]
            ])->iconAppend('envelope')->input('email');
        echo $form->field(
            $model,
            'password',
            [
                'inputOptions' => [
                    'tabindex' => 2
                ]
            ])->iconAppend('lock')->passwordInput()->hint(Html::a('Forgot password?', 'forgot-password'));

        if (Yii::$app->getUser()->enableAutoLogin === true) {
            echo $form->field($model, 'rememberMe')->checkbox()->label(false);
        }
        ?>
    </fieldset>

    <footer>
        <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary', 'tabindex' => 3]) ?>
    </footer>
<?php ActiveForm::end() ?>