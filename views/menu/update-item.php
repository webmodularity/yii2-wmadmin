<?php

use wma\widgets\ActiveForm;
use wma\widgets\buttons\DeleteButton;
use wma\widgets\buttons\UpdateButton;
use wma\widgets\NestedList;
use yii\helpers\Html;
use wma\widgets\Box;

$this->title = "Menu Item: ".$menuItem->name."";
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Menu: ".$menu->name."", 'url' => ['update', 'id' => $menu->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Menus';
?>

<?= Yii::$app->alertManager->get() ?>

    <div class="row">
    <div class="col-md-6">
<?php $form = ActiveForm::begin() ?>
<?php Box::begin(
    [
        'title' => 'Menu Item Update',
        'responsive' => false,
        'tools' => [Html::tag('span', "ID: ".$menuItem->id."", ['class' => 'label label-default'])],
        'footer' => [
            DeleteButton::widget(['model' => $menuItem, 'itemName' => 'Menu Item']),
            UpdateButton::widget(['itemName' => 'Menu Item'])
        ]
    ]
) ?>
<?= $this->render('_formItem', ['form' => $form, 'menuItem' => $menuItem, 'menu' => $menu]) ?>
<?php Box::end() ?>
<?php ActiveForm::end() ?>
<?php $form = ActiveForm::begin(['action' => ['move-item']]) ?>
<?php Box::begin(
    [
        'title' => 'Menu Item Move',
        'responsive' => false,
        'tools' => [Html::tag('span', "ID: ".$menuItem->id."", ['class' => 'label label-default'])],
        'footer' => [UpdateButton::widget(['updateText' => 'Move', 'itemName' => 'Menu Item'])]
    ]
) ?>
<?= Html::activeHiddenInput($menuItem, 'id') ?>
<?= $this->render('_formItemPosition', ['form' => $form, 'menuItem' => $menuMove, 'menu' => $menu]) ?>
<?php Box::end() ?>
<?php ActiveForm::end() ?>

</div>
<div class="col-md-6">
<?php Box::begin(
    [
        'title' => "".$menu->name." - Items",
        'tools' => [
            Html::tag('span', "CURRENT", ['class' => 'label bg-orange']),
            Html::tag('span', "HEADER", ['class' => 'label bg-purple']),
            Html::tag('span', "DIVIDER", ['class' => 'label bg-teal'])
        ]
    ]
) ?>
<?= NestedList::widget(['menuId' => $menu->id, 'userPermissionFilter' => false, 'childDepth' => 6, 'currentId' => $menuItem->id]) ?>
<?php Box::end() ?>
    </div>
        </div>
