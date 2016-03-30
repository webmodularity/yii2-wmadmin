<?php

use yii\helpers\Html;
use wma\widgets\Box;
use wma\grid\GridView;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel wma\models\FilePathSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'File Paths';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'File Paths';
?>
<?= Yii::$app->alertManager->get() ?>

<?php Box::begin([
        'title' => $this->title,
        'padding' => false,
        'headerBorder' => false,
        'tools' => [
            Html::a(FA::icon('plus') . ' ' . Html::tag('span', 'Add New File Path', ['class' => 'hidden-xs']), ['create'], ['class' => 'btn btn-sm btn-success'])
        ]
    ]
) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'wma\grid\SerialColumn'],
        'id',
        'path',
        'alias',
        ['class' => 'wma\grid\ActionColumn'],
    ],
]); ?>
<?php Box::end() ?> 