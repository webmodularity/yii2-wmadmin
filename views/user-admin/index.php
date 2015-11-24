<?php

use yii\helpers\Html;
use wma\widgets\Box;
use wma\grid\GridView;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Users';
$addText = 'Add User';
?>

<?= Yii::$app->alertManager->get() ?>

<?php Box::begin([
    'title' => $this->title,
    'padding' => false,
    'headerBorder' => false
]) ?>
<?= GridView::widget([
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

        [
            'class' => 'wma\grid\ActionColumn',
            'deleteDisabled' => function ($model){return Yii::$app->user->id == $model->id;}
        ]
    ],
]); ?>
<?php Box::end() ?>