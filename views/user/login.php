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
        <?php
        echo $form->field(
            $model,
            'email',
            [
                'inputOptions' => [
                    'tabindex' => 1,
                    'autofocus' => 'autofocus'
                ]
            ])->input('email')->iconAppend('envelope');
        echo $form->field(
            $model,
            'password',
            [
                'inputOptions' => [
                    'tabindex' => 2
                ]
            ])->passwordInput()->iconAppend('lock')->hint(Html::a('Forgot password?', 'forgot-password'));

        if (Yii::$app->getUser()->enableAutoLogin === true) {
            echo $form->field($model, 'rememberMe')->checkbox()->label(false);
        }
        ?>
    </fieldset>

    <footer>
        <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary', 'tabindex' => 3]) ?>
    </footer>
<?php ActiveForm::end() ?>