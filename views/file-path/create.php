<?php

use wma\widgets\ActiveForm;
use wma\widgets\buttons\AddButton;
use yii\helpers\Html;
use wma\widgets\Box;

/* @var $this yii\web\View */
/* @var $model wmc\models\FilePath */

$this->title = 'File Path - Add New';
$this->params['breadcrumbs'][] = ['label' => 'File Paths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'File Paths';
?>

<?= Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-6">

        <?php $form = ActiveForm::begin() ?>

        <?php Box::begin(
            [
                'title' => 'File Path Details',
                'responsive' => false,
                'tools' => [],
                'footer' => [AddButton::widget(['itemName' => 'File Path'])]
            ]
        ) ?>

        <?= $this->render('_form', ['form' => $form, 'model' => $model]) ?>

        <?php Box::end() ?>

        <?php ActiveForm::end() ?>

    </div>
</div>