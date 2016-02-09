<?php

use wma\widgets\ActiveForm;
use wma\widgets\UpdateButton;
use yii\helpers\Html;
use wma\widgets\Box;

/* @var $this yii\web\View */
/* @var $model wmc\models\File */

$this->title = 'File: ' . $model->fullAlias;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->params['wma-nav'] = 'Files';
?>

<?= Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-6">

        <?php $form = ActiveForm::begin() ?>

        <?php Box::begin(
            [
                'title' => 'File Details',
                'responsive' => false,
                'tools' => [
                    Html::tag('span', "ID: ".$model->id."", ['class' => 'label label-primary'])
                ],
                'footer' => [
                    UpdateButton::widget(['itemName' => 'File'])
                ]
            ]
        ) ?>

        <?= $this->render('_form', ['form' => $form, 'model' => $model]) ?>

        <?php Box::end() ?>

        <?php ActiveForm::end() ?>

    </div>
</div>