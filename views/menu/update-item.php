<?php

use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use wma\widgets\ActiveForm;
use wma\widgets\DeleteButton;
use wma\widgets\UpdateButton;
use wma\widgets\NestedList;
use yii\helpers\Html;
use yii\bootstrap\Button;
use kartik\select2\Select2;
use rmrevin\yii\fontawesome\FA;

$this->title = "Menu Item: ".$menuItemForm->name."";
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Menu: ".$menu->name."", 'url' => ['update', 'id' => $menu->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Menus';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['title' => 'Menu Item', 'subTitle' => $menuItemForm->name, 'icon' => 'cog']) ?>

<?= Yii::$app->alertManager->render() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-6 col-lg-6"]]) ?>

<?php Widget::begin(
    [
        'id' => 'menu-item-update',
        'title' => 'Menu Item Update',
        'icon' => 'list',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [Html::tag('span', "ID: ".$menuItemForm->id."", ['class' => 'label label-default'])]
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'smart-form']]) ?>
<?= $this->render('_formItem', ['form' => $form, 'model' => $menuItemForm, 'menu' => $menu]) ?>
    <footer>
        <?= UpdateButton::widget(['itemName' => 'Menu Item']) ?>
        <?= DeleteButton::widget(['model' => $menuItemForm, 'itemName' => 'Menu Item', 'deleteUrl' => "delete-item"]) ?>
    </footer>
<?php ActiveForm::end() ?>
<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php Widget::begin(
    [
        'id' => 'menu-item-move',
        'title' => 'Menu Item Move',
        'icon' => 'list',
        'buttons' => ['toggle'],
        'sortable' => true
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'smart-form']]) ?>
<?= $this->render('_formItemPosition', ['form' => $form, 'model' => $menuItemForm->position, 'menu' => $menu]) ?>
    <footer>
        <?= UpdateButton::widget(['updateText' => 'Move', 'itemName' => 'Menu Item']) ?>
    </footer>
<?php ActiveForm::end() ?>
<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-6 col-lg-6"]]) ?>

<?php Widget::begin(
    [
        'id' => 'menu-list-items',
        'title' => $menu->name,
        'icon' => 'list',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [
            Html::tag('span', "DIVIDER", ['class' => 'label bg-color-pinkDark']),
            Html::tag('span', "HEADER", ['class' => 'label bg-color-blueLight']),
            Html::tag('span', "CURRENT", ['class' => 'label bg-color-orange'])
        ]
    ]
) ?>
<?php WidgetBody::begin() ?>

<?= NestedList::widget(['menuId' => $menu->id, 'userPermissionFilter' => false, 'childDepth' => 6, 'currentId' => $menuItemForm->id]) ?>

<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>