<?php

use yii\helpers\Html;
use wma\widgets\Box;
use wma\widgets\DetailView;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $model wmc\models\Log */

$this->title = "Backend Log Entry: ".$model->id."";
$this->params['breadcrumbs'][] = ['label' => 'Backend Log', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Backend Log';
?>

<?= Yii::$app->alertManager->get() ?>

<?php Box::begin(
    [
        'title' => 'Backend Log Entry',
        'padding' => false,
        'headerBorder' => false,
        'tools' => [
            Html::tag('span', "ID: ".$model->id."", ['class' => 'label label-primary']),
            Html::a(FA::icon('chevron-left'), ['view', 'id' => ($model->id)-1], ['class' => 'btn btn-box-tool']),
            Html::a(FA::icon('chevron-right'), ['view', 'id' => ($model->id)+1], ['class' => 'btn btn-box-tool']),
        ]
    ]
) ?>
<?= DetailView::widget([
    'model' => $model,
    'wrapLong' => true,
    'attributes' => [
        'level',
        'category',
        'log_time:datetime',
        'prefix:ntext',
        'message:ntext',
    ],
]) ?>
<?php Box::end() ?>
