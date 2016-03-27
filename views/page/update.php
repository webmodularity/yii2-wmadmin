<?php

use wma\widgets\ActiveForm;
use wma\widgets\buttons\UpdateButton;
use yii\helpers\Html;
use wma\widgets\Box;

$this->title = 'Page: ' . ' ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Pages';
?>
<?= Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-12">

<?php $form = ActiveForm::begin() ?>

<?php Box::begin(
    [
        'title' => 'Page Details',
        'responsive' => false,
        'tools' => [
            Html::tag('span', "ID: ".$page->id."", ['class' => 'label label-primary'])
        ],
        'footer' => [
            UpdateButton::widget(['itemName' => 'Page'])
        ]
    ]
) ?>

<?= $this->render('_form', ['form' => $form, 'page' => $page, 'pageMarkdown' => $pageMarkdown, 'pageMenuIntegration' => $pageMenuIntegration]) ?>

<?php Box::end() ?>

<?php ActiveForm::end() ?>

    </div>
</div>
