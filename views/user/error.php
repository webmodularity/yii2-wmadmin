<?php

use yii\helpers\Html;
use wma\widgets\Alert;

$this->title = 'Error'; ?>
<?= Alert::widget([
    'callout' => true,
    'heading' => $statusCode . ' ' . $exception->getName() . " Error",
    'message' => $exception->getMessage(),
    'icon' => 'ban',
    'style' => 'danger'
])?>

<p class="login-box-msg"><?= Html::a('Return Home', Yii::$app->getHomeUrl()) ?></p>