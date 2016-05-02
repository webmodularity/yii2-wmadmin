<?php

use wma\widgets\ActiveForm;
use wma\widgets\buttons\AddButton;
use yii\helpers\Html;
use wma\widgets\Box;
use wmc\models\FilePath;
use wmc\models\user\UserGroup;
use wma\widgets\input\file\FileInputCreate;

/* @var $this yii\web\View */
/* @var $model wmc\models\File */

$this->title = 'File - Add New';
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Add New File';
?>

<?= Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-6">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?php Box::begin(
            [
                'title' => 'File Details',
                'responsive' => false,
                'tools' => [],
                'footer' => [AddButton::widget(['itemName' => 'File'])]
            ]
        ) ?>

        <?= $form->field($model, 'fileUpload')->widget(FileInputCreate::classname(), [
        ])->hint($model->getAllowedFileExtensionsHint('fileUpload')) ?>

        <div class="row">
            <?= $form->field($model, 'file_path_id')->dropDownList(FilePath::getFilePathList())->label('File Path')->colSpan(6) ?>

            <?= $form->field($model, 'alias')->textInput(['maxlength' => true])->label('File Alias (Optional)')->hint("The name used to refer to this file in the URL. Leaving this field empty (default) uses the original name of the file. Do not include file extension in alias.")->colSpan(6) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'status')->dropDownList([0 => 'Disabled', 1 => 'Active'])->label('File Status')->hint('Setting a file\'s Status to Disabled will cause the server to return a 404 Not Found response when the file is requested.')->colSpan(6) ?>

            <?= $form->field($model, 'inline')->dropDownList([0 => 'Yes', 1 => 'No'])->label('Download Only?')->hint('Setting this to "Yes" will trigger a Download File dialog when this file is accessed rather than displaying the file inline.')->colSpan(6) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'userGroupIds')->inline()->checkboxList(UserGroup::getAccessibleGroupList())->label('User Group Access')->colspan(6) ?>
        </div>

        <?php Box::end() ?>

        <?php ActiveForm::end() ?>

    </div>
</div>