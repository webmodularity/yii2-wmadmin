<?php

use wma\widgets\ActiveForm;
use wmc\helpers\Html;

$this->title = 'Login';
$form = ActiveForm::begin([
        'options' => ['class' => 'client-form']
    ]) ?>
    <header>
        Sign In
    </header>

    <fieldset>
        <?php
        echo $form->field(
            $model,
            'username',
            [
                'inputOptions' => [
                    'tabindex' => 1,
                    'autofocus' => 'autofocus'
                ]
            ])->iconAppend('user')->hint(Html::a('Forgot username?', 'forgot-username'));
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