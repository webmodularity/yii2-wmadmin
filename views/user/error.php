<?php

use wmc\helpers\Html;
use wma\widgets\Alert;

$this->title = $name;
$this->context->layout = 'login-error';

echo Alert::widget([
        'message' => nl2br(Html::encode($message)),
        'heading' => Html::encode($name),
        'block' => true,
        'style' => 'danger'
    ]
);