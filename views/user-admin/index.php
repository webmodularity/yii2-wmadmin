<?php

use yii\helpers\Html;
use wma\widgets\Box;
use wma\grid\GridView;
use kartik\export\ExportMenu;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Users';
$addText = 'Add User';
?>

<?= Yii::$app->alertManager->get() ?>

<?php
$gridColumns = [
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
];

Box::begin([
    'title' => $this->title,
    'padding' => false,
    'headerBorder' => false,
    'tools' => [
        ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'fontAwesome' => true,
            'showConfirmAlert' => false,
            'target' => ExportMenu::TARGET_SELF,
            'dropdownOptions' => [
                'label' => 'Export',
                'class' => 'btn btn-default'
            ],
            'selectedColumns' => [1, 2, 3],
            'noExportColumns' => [0, 6],
            'exportConfig' => [
                ExportMenu::FORMAT_PDF => false
            ]
        ])
    ]
]);
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns
]); ?>
<?php Box::end() ?>
