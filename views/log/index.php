<?php

use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBodyGridView;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use wma\grid\ActionColumn;
use yii\helpers\Html;
use yii\bootstrap\Button;
use kartik\select2\Select2;
use rmrevin\yii\fontawesome\FA;
use wmu\models\User;
use wmu\models\UserGroup;

$this->title = 'Error Log';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Error Log';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['subTitle' => 'Error Log', 'icon' => 'ban']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>
<?php Widget::begin(
    [
        'id' => 'error-log-list-all',
        'title' => 'Error Log',
        'icon' => 'ban',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => []
    ]
) ?>

<?= WidgetBodyGridView::widget([
    'bodyOptions' => [
        'padding' => false
    ],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'level',
        'category',
        'log_time:datetime',
        'prefix:ntext',
        // 'message:ntext',

        [
            'class' => 'wma\grid\ActionColumn',
            'template' => '{view}',
            'iconOnly' => true,
        ],
    ],
]); ?>

<?php Widget::end() ?>
<?php WidgetContainer::end() ?>


<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>