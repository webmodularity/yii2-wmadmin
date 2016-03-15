<?php

use yii\helpers\Html;
use wma\widgets\Box;
use wma\grid\GridView;
use wmc\models\FilePath;

/* @var $this yii\web\View */
/* @var $searchModel wma\models\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Yii::$app->formatter->sizeFormatBase = 1000;

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'All Files';
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
        'id',
        [
            'class' => 'wma\grid\data\FileTypeColumn',
            'attribute' => 'file_type_id',
            'label' => 'Type'
        ],
        [
            'attribute' => 'file_path_id',
            'value' => 'filePath.path',
            'label' => 'Path',
            'filter' => FilePath::getFilePathList()
        ],
        [
            'attribute' => 'alias',
            'label' => 'Name',
            'value' => function ($model, $key, $index, $column) {
                return $model->fullAlias;
            }
        ],
        [
            'attribute' => 'bytes',
            'label' => 'Size',
            'format' => 'shortSize'
        ],
        [
            'class' => 'wma\grid\data\StatusColumn',
            'attribute' => 'status'
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
        ['class' => 'wma\grid\ActionColumn'],
    ],
]); ?>
<?php Box::end() ?>