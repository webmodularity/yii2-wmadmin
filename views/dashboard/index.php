<?php

use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\Alert;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;

$this->title = 'Dashboard';
?>
<?= Ribbon::widget(['links' => ['Dashboard']]) ?>

<?php ContentContainer::begin() ?>

    <?= PageTitle::widget(['subTitle' => 'My Dashboard', 'icon' => 'home']) ?>

    <?php WidgetGrid::begin() ?>
        <?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-6 col-md-6 col-lg-6"]]) ?>
            <?php Widget::begin(
                [
                    'id' => 'dashboard-widget',
                    'title' => 'My Dashboard Widget',
                    'icon' => 'home',
                    'load' => "/dashboard/ajax",
                    'buttons' => ['refresh', 'toggle'],
                    'sortable' => true
                ]
            ) ?>
                <?php WidgetBody::begin() ?>
                    <!-- <h3 class="alert alert-success">Dashboard Widget Alert Box</h3> -->
                <?php WidgetBody::end() ?>
            <?php Widget::end() ?>
        <?php WidgetContainer::end() ?>
        <?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-6 col-md-6 col-lg-6"]]) ?>


    <?php Widget::begin(
        [
            'id' => 'dashboard-widget2',
            'title' => 'My Dashboard Widget 2',
            'icon' => 'windows',
            'buttons' => ['toggle', 'color', 'delete', 'fullscreen'],
            'sortable' => true
        ]
    ) ?>
    <?php WidgetBody::begin() ?>
         <?= Alert::widget(['message' => 'Dashboard Widget Alert Box', 'heading' => 'Success', 'style' => 'success', 'block' => true, 'close' => false]) ?>
    <?php WidgetBody::end() ?>
    <?php Widget::end() ?>
        <?php WidgetContainer::end() ?>
    <?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>