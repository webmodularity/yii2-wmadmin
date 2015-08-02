<?php

use yii\widgets\DetailView;
use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use yii\helpers\Html;
use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $model wmc\models\Log */

$this->title = "Log ID: ".$model->id."";
$this->params['breadcrumbs'][] = ['label' => 'Error Log', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Frontend Log';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['title' => 'Error Log', 'subTitle' => $model->id, 'icon' => 'ban']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>

<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>

<?php Widget::begin(
    [
        'id' => 'error-log-frontend-view',
        'title' => 'Error Log Detail View',
        'icon' => 'ban',
        'buttons' => ['fullscreen', 'toggle'],
        'sortable' => true,
        'toolbars' => [Html::tag('span', "ID: ".$model->id."", ['class' => 'label label-default'])]
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'level',
            'category',
            'log_time:datetime',
            'prefix:ntext',
            'message:ntext',
        ],
    ]) ?>

<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>