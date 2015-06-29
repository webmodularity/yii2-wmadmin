<?php

use wma\widgets\WidgetBodyGridView;
use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use wma\grid\ActionColumn;
use wma\widgets\ModalForm;
use yii\helpers\Html;
use yii\bootstrap\Button;
use kartik\select2\Select2;
use rmrevin\yii\fontawesome\FA;

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Menus';
$addText = 'Add New Menu';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['subTitle' => 'All Root Menus', 'icon' => 'cog']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>
<?php Widget::begin(
    [
        'id' => 'menu-list-all',
        'title' => 'Menus',
        'icon' => 'list',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [
            Button::widget([
                'options' => [
                    'class' => 'btn-success',
                    'data-target' => '#menuAddModal',
                    'data-toggle' => 'modal'
                ],
                'encodeLabel' => false,
                'label' => FA::icon('plus') . ' ' . Html::tag('span', $addText, ['class' => 'hidden-xs'])
            ])
        ]
    ]
) ?>
<?= WidgetBodyGridView::widget([
    'bodyOptions' => [
        'padding' => false
    ],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'wma\grid\SerialColumn'],
        'name',
        'icon',
        [
            'class' => ActionColumn::className()
        ]
    ],
]); ?>
<?php Widget::end() ?>
<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>

<?php
$form = ModalForm::begin([
    'id' => 'menuAddModal',
    'headerText' => $addText,
    'submitText' => $addText,
    'size' => ModalForm::SIZE_SMALL,
    'clientOptions' => ['show' => $addModel->hasErrors()]
]);
?>
<?= $this->render('_form', ['model' => $addModel, 'form' => $form->form]) ?>
<?php ModalForm::end(); ?>