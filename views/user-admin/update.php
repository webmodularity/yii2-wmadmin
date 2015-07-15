<?php

use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use wma\widgets\ActiveForm;
use wma\widgets\DeleteButton;
use wma\widgets\UpdateButton;
use wma\widgets\Alert;
use wma\widgets\WidgetBodyGridView;
use yii\helpers\Html;
use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;

$this->title = "User: ".$model->email."";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Users';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['title' => 'User', 'subTitle' => $model->email, 'icon' => 'user']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-6"]]) ?>

<?php Widget::begin(
    [
        'id' => 'user-update',
        'title' => 'User Update',
        'icon' => 'user',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [Html::tag('span', "ID: ".$model->id."", ['class' => 'label label-default'])]
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>
<?php

    if (Yii::$app->user->id == $model->id) {
        // Editing your own user info
        echo Alert::widget([
            'message' => "You are updating your own user record so delete and update options are limited.",
            'style' => 'info',
            'icon' => 'info',
            'encode' => false
        ]);
    }

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'smart-form']]) ?>
<?= $this->render('_form', ['form' => $form, 'model' => $model, 'primaryAddress' => $primaryAddress, 'shippingAddress' => $shippingAddress]) ?>
    <footer>
        <?= UpdateButton::widget(['itemName' => 'User']) ?>
        <?= DeleteButton::widget(['model' => $model, 'disabled' => Yii::$app->user->id == $model->id]) ?>
    </footer>
<?php ActiveForm::end() ?>
<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-6"]]) ?>
<?php Widget::begin(
    [
        'id' => 'user-list-all',
        'title' => "User Log: ".$model->email."",
        'icon' => 'user',
        'buttons' => ['toggle', 'fullscreen'],
        'sortable' => true,
        'toolbars' => []
    ]
) ?>
<?= WidgetBodyGridView::widget([
    'bodyOptions' => [
        'padding' => false
    ],
    'dataProvider' => $logDataProvider,
    'filterModel' => $logSearchModel,
    'columns' => [
        ['class' => 'wma\grid\SerialColumn'],
        [
            'class' => 'wma\grid\data\UserLogAppColumn',
            'attribute' => 'app'
        ],
        [
            'class' => 'wma\grid\data\UserLogActionColumn',
            'attribute' => 'action_type'
        ],
        [
            'class' => 'wma\grid\data\UserLogResultColumn',
            'attribute' => 'result_type'
        ],
        [
            'class' => 'wma\grid\DataColumn',
            'attribute' => 'ip',
            'format' => 'ip',
            'enableSorting' => false
        ],
        [
            'class' => 'wma\grid\DataColumn',
            'attribute' => 'created_at',
            'format' => 'datetime',
            'label' => "From the Last",
            'filter' => \wmu\models\UserLog::getIntervalList(),
            'enableSorting' => false
        ],
        [
            'class' => 'wma\grid\ActionColumn',
            'template' => '{view}',
            'iconOnly' => true,
            'urlCreator' => function($action, $model, $key, $index) {
                return \yii\helpers\Url::toRoute(['view-user-log', 'id' => $model->id]);
            }
        ],
    ],
]); ?>
<?php Widget::end() ?>
<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>