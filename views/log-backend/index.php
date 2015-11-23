<?php

use wma\grid\GridView;
use yii\helpers\Html;
use wma\widgets\Box;

$this->title = 'Backend Log';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Backend Log';
?>

<?= Yii::$app->alertManager->get() ?>

<?php Box::begin(['title' => $this->title, 'padding' => false, 'headerBorder' => false]) ?>
<?= GridView::widget([
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
<?php Box::end() ?>
