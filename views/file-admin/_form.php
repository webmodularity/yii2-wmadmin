<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wmc\models\File */
/* @var $form yii\widgets\ActiveForm */
?>

<?= $form->field($model, 'file_path_id')->textInput() ?>

<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'inline')->textInput() ?>

<?= $form->field($model, 'status')->textInput() ?>