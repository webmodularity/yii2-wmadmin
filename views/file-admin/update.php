<?php

use wma\widgets\ActiveForm;
use wma\widgets\buttons\UpdateButton;
use yii\helpers\Html;
use wma\widgets\Box;
use wmc\models\FilePath;
use wmc\models\user\UserGroup;

/* @var $this yii\web\View */
/* @var $model wmc\models\File */

$this->title = 'File: ' . $model->fullAlias;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['wma-nav'] = 'All Files';
?>

<?= Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-6">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?php
        Yii::$app->formatter->sizeFormatBase = 1000;
        Box::begin(
            [
                'title' => 'File Details',
                'responsive' => false,
                'tools' => [
                    Html::tag('span', "Size: ".Yii::$app->formatter->asShortSize($model->bytes)."", ['class' => 'label label-success'])
                ],
                'footer' => [UpdateButton::widget(['itemName' => 'File'])]
            ]
        ) ?>

        <div class="row">
            <?= $form->field($model, 'file_path_id')->dropDownList(FilePath::getFilePathList())->label('File Path')->hint('Changing the File Path will move the file.')->colSpan(6) ?>

            <?= $form->field($model, 'alias')->textInput(['maxlength' => true])->label('File Alias')->hint("The name used to refer to this file in the URL. Do not include extension.")->colSpan(6) ?>
        </div>


        <div class="row">
            <?= $form->field($model, 'name')->textInput(['readonly' => true])->label('File Name')->hint("This is the name of the file on the server.")->colSpan(6) ?>

            <?= $form->field($model, 'upload_file')->fileInput(['disabled' => true])->hint('File updating temporarily disabled. Delete and Add New to change file.')->colSpan(6) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'status')->dropDownList([0 => 'Disabled', 1 => 'Active'])->label('File Status')->hint('Setting a file\'s Status to Disabled will cause the server to return a 404 Not Found response when the file is requested.')->colSpan(6) ?>

            <?= $form->field($model, 'inline')->dropDownList([0 => 'Yes', 1 => 'No'])->label('Download Only?')->hint('Setting this to "Yes" will trigger a Download File dialog when this file is accessed rather than displaying the file inline.')->colSpan(6) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'userGroupIds')->inline()->checkboxList(UserGroup::getAccessibleGroupList())->label('User Group Access')->colSpan(6) ?>
        </div>

        <?php Box::end() ?>

        <?php ActiveForm::end() ?>

    </div>
</div>