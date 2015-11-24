<?php

use yii\helpers\Html;
use wma\widgets\Box;
use wma\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model wmu\models\UserLog */
/* @var $userModel wmu\models\User */

$this->title = "User Log ID: ".$model->id."";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->email, 'url' => ['update', 'id' => $model->user->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Users';
?>

<?= Yii::$app->alertManager->get() ?>

<?php Box::begin(
    [
        'title' => 'User Log View',
        'padding' => false,
        'headerBorder' => false,
        'tools' => [Html::tag('span', "ID: ".$model->id."", ['class' => 'label label-default'])]
    ]
) ?>
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

<?php Box::end() ?>