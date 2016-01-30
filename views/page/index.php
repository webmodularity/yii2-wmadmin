<?php

use yii\helpers\Html;
use wma\grid\ActionColumn;
use wma\widgets\Box;
use wma\grid\GridView;

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'All Pages';
?>
<?= Yii::$app->alertManager->get() ?>

<?php Box::begin([
        'title' => $this->title,
        'padding' => false,
        'headerBorder' => false,
        'tools' => []
    ]
) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'wma\grid\SerialColumn'],
        'title',
        [
            'attribute' => 'name',
            'label' => 'URL'
        ],
        [
            'class' => 'wma\grid\data\StatusColumn',
            'attribute' => 'status'
        ],
        [
            'attribute' => 'html',
            'format' => 'text',
            'label' => 'Preview',
            'value' => function ($model, $key, $index, $column) {
                return substr(preg_replace('/\s+/S', " ", strip_tags($model->html)), 0, 50) . '...';
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'filter' => false
        ],
        [
            'attribute' => 'updated_at',
            'format' => 'datetime',
            'filter' => false
        ],
        [
            'class' => ActionColumn::className()
        ],
    ]
]); ?>
<?php Box::end() ?>