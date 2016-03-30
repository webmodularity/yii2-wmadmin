<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wmc\models\FilePath */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'path')->textInput(['maxlength' => true])->hint('Path may contain aliases (@frontend, @common, @backend, etc.). Should refer to a full path that is writeable by web server.') ?>

<?= $form->field($model, 'alias')->textInput(['maxlength' => true])->hint('Alias is used to refer to file path in URL. (http://url.com/file/*alias*/*filename*)') ?>
