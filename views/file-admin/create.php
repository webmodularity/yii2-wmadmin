<?php

use wma\widgets\ActiveForm;
use wma\widgets\buttons\AddButton;
use yii\helpers\Html;
use wma\widgets\Box;

/* @var $this yii\web\View */
/* @var $model wmc\models\File */

$this->title = 'File - Add New';
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Add New File';
?>

<?= Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-12">

        <?php $form = ActiveForm::begin() ?>

        <?php Box::begin(
            [
                'title' => 'File Details',
                'responsive' => false,
                'tools' => [],
                'footer' => [AddButton::widget(['itemName' => 'File'])]
            ]
        ) ?>

        <?= $this->render('_form', ['form' => $form, 'model' => $model]) ?>

        <?php Box::end() ?>

        <?php ActiveForm::end() ?>

    </div>
</div>