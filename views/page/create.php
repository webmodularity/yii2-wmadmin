<?php

use wma\widgets\ActiveForm;
use wma\widgets\buttons\AddButton;
use yii\helpers\Html;
use wma\widgets\Box;

$this->title = 'Page - Add New';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Add New Page';
?>

<?= Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-12">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?php Box::begin(
    [
        'title' => 'Page Details',
        'responsive' => false,
        'tools' => [],
        'footer' => [AddButton::widget(['itemName' => 'Page'])]
    ]
) ?>
<?= $this->render('_form', ['form' => $form, 'page' => $page, 'pageMarkdown' => $pageMarkdown, 'pageMenuIntegration' => $pageMenuIntegration]) ?>

<?php Box::end() ?>

<?php ActiveForm::end() ?>

    </div>
</div>