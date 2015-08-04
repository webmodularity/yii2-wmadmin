<?php

use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBodyGridView;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use yii\helpers\Html;
use yii\bootstrap\Button;
use kartik\select2\Select2;
use rmrevin\yii\fontawesome\FA;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Users';
$addText = 'Add New User';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['subTitle' => 'Site Users', 'icon' => 'users']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>
<?php Widget::begin(
    [
        'id' => 'user-list-all',
        'title' => 'Users',
        'icon' => 'user',
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
        ['class' => 'wma\grid\SerialColumn'],

        'id',
        [
            'attribute' => 'fullName',
            'label' => 'Name',
            'value' => 'person.fullName',
        ],
        [
            'attribute' => 'email',
            'value' => 'email'
        ],
        [
            'class' => 'wma\grid\data\UserGroupColumn',
            'attribute' => 'group_id',
        ],
        [
            'class' => 'wma\grid\data\UserStatusColumn',
            'attribute' => 'status',
            'label' => 'Status'
        ],
        // 'created_at',
        // 'updated_at',

        ['class' => 'wma\grid\ActionUserAdminColumn'],
    ],
]); ?>
<?php Widget::end() ?>
<?php WidgetContainer::end() ?>


<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>