<?php

use wma\widgets\ActiveForm;
use wma\widgets\DeleteButton;
use wma\widgets\UpdateButton;
use wma\widgets\Alert;
use yii\bootstrap\Html;
use wmc\helpers\ConstantHelper;
use rmrevin\yii\fontawesome\FA;
use kartik\select2\Select2;
use wma\widgets\Box;
use wma\grid\GridView;

$this->title = "User: ".$model->email."";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Users';
?>
<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-6"]]) ?>

<?php Widget::begin(
    [
        'id' => 'user-update',
        'title' => 'User',
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
<?= $this->render('_form', ['form' => $form, 'model' => $model]) ?>
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
        'id' => 'user-log-all',
        'title' => 'User Log',
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
            'filter' => \wmc\models\user\UserLog::getIntervalList(),
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

<?php Widget::begin(
    [
        'id' => 'user-keys',
        'title' => "User Keys",
        'icon' => 'key',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [Html::a(FA::icon('plus') . ' Generate New Auth Key', ['user-key-create', 'user_id' => $model->id], ['class' => 'btn btn-success'])],
        'hidden' => !Yii::$app->user->can('su')
    ]
) ?>
<?php if (Yii::$app->user->can('su')) {
    echo WidgetBodyGridView::widget([
        'bodyOptions' => [
            'padding' => false
        ],
        'dataProvider' => $keyDataProvider,
        'columns' => [
            ['class' => 'wma\grid\SerialColumn'],
            [
                'attribute' => 'type',
                'value' => function ($model, $key, $index, $column) {
                    return ConstantHelper::humanizedFromValue(\wmc\models\user\UserKey::className(),'TYPE_', $model->type);
                },
                'enableSorting' => false
            ],
            ['attribute' => 'user_key', 'enableSorting' => false],
            ['attribute' => 'created_at', 'format' => 'datetime', 'enableSorting' => false],
            ['attribute' => 'expire', 'format' => 'datetime', 'enableSorting' => false],
            [
                'class' => 'wma\grid\ActionColumn',
                'template' => '{delete}',
                'iconOnly' => true,
                'urlCreator' => function($action, $keyModel, $key, $index) use ($model) {
                    return \yii\helpers\Url::toRoute(['user-key-delete', 'id' => $keyModel->id, 'user_id' => $model->id]);
                }
            ],
        ],
    ]);
}?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>