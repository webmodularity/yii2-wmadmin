<?php


use wma\grid\ActionColumn;
use wma\widgets\ModalForm;
use yii\helpers\Html;
use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;
use wma\widgets\Box;
use wma\grid\GridView;

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Menus';
$addText = 'Add Menu';
?>

<?= Yii::$app->alertManager->get() ?>

<?php Box::begin([
        'title' => $this->title,
        'padding' => false,
        'headerBorder' => false,
        'tools' => [
            Button::widget([
                'options' => [
                    'class' => 'btn-success btn-sm',
                    'data-target' => '#menuAddModal',
                    'data-toggle' => 'modal'
                ],
                'encodeLabel' => false,
                'label' => FA::icon('plus') . ' ' . Html::tag('span', $addText, ['class' => 'hidden-xs'])
            ])
        ]
    ]
) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'wma\grid\SerialColumn'],
        'name',
        'icon:html:Icon Set Name',
        [
            'class' => ActionColumn::className()
        ]
    ],
]); ?>
<?php Box::end() ?>

<?php
$form = ModalForm::begin([
    'id' => 'menuAddModal',
    'headerText' => $addText,
    'submitText' => $addText,
    'size' => ModalForm::SIZE_SMALL,
    'clientOptions' => ['show' => $model->hasErrors()]
]);
?>
<?= $this->render('_form', ['model' => $model, 'form' => $form->form]) ?>
<?php ModalForm::end(); ?>