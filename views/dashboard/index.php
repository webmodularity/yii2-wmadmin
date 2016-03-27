<?php

use yii\helpers\Html;
use wma\widgets\InfoBox;
use yii\helpers\Url;

$this->title = 'Dashboard';
$this->params['wma-nav'] = "Dashboard";
$this->params['breadcrumbs'][] = 'Dashboard';
?>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <?= InfoBox::widget(['value' => $activeUsers, 'name' => 'Active Users', 'icon' => 'users', 'link' => Url::to(['user-admin/index', 'UserSearch[status]' => 1])]); ?>
    </div>
    <div class="col-lg-4 col-xs-6">
        <?= InfoBox::widget(['value' => $pendingUsers, 'name' => 'Pending Users', 'icon' => 'user-plus', 'bgColor' => 'yellow', 'link' => Url::to(['user-admin/index', 'UserSearch[status]' => 0])]); ?>
    </div>
</div>


