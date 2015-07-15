<?php

use yii\widgets\DetailView;
use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use wma\helpers\Html;
use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $model wmu\models\UserLog */
/* @var $userModel wmu\models\User */

$this->title = "User Log ID: ".$model->id."";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->email, 'url' => ['update', 'id' => $model->user->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Users';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['title' => 'UserLog', 'subTitle' => $model->id, 'icon' => 'user']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>

<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>

<?php Widget::begin(
    [
        'id' => 'user-update',
        'title' => 'User Log',
        'icon' => 'user',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [Html::tag('span', "ID: ".$model->id."", ['class' => 'label label-default'])]
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.email:raw:User',
            'app:userLogApp',
            'action_type:userLogAction',
            'result_type:userLogResult',
            'data',
            'path.path',
            'userAgent.user_agent',
            'session_id',
            'ip:ip',
            'created_at:datetime',
        ],
    ]) ?>

<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>