<?php

use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBodyGridView;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel wmf\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Pages';
$addText = 'Add New ' . 'Page';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['subTitle' => '', 'icon' => '']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>
<?php Widget::begin(
    [
        'id' => 'page-list-all',
        'title' => 'Pages',
        'icon' => '',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [
            Html::a(FA::icon('plus') . ' ' . 'Add ' . 'Page', ['create'], ['class' => 'btn btn-success'])
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
        'title',
        [
            'class' => 'wma\grid\data\StatusColumn',
            'attribute' => 'status'
        ],
        [
            'attribute' => 'html',
            'format' => 'text',
            'label' => 'Content',
            'value' => function ($model, $key, $index, $column) {
                return substr(preg_replace('/\s+/S', " ", strip_tags($model->html)), 0, 50) . '...';
            }
        ],
        [
            'attribute' => 'updated_at',
            'format' => 'datetime',
            'filter' => false
        ],
        // 'created_at',
        ['class' => 'wma\grid\ActionUserAdminColumn'],
    ],
]); ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>