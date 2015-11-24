<?php

use wma\widgets\ActiveForm;
use wma\widgets\DeleteButton;
use wma\widgets\UpdateButton;
use wma\widgets\NestedList;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use wma\widgets\Box;

$this->title = "Menu: ".$menu->name."";
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Menus';
?>
<?= Yii::$app->alertManager->get() ?>

    <div class="row">
    <div class="col-md-6">

<?php Box::begin(
    [
        'title' => "".$menu->name." - Items",
        'tools' => [
            Html::tag('span', "HEADER", ['class' => 'label bg-purple']),
            Html::tag('span', "DIVIDER", ['class' => 'label bg-teal'])
        ]
    ]
) ?>

<?= NestedList::widget(['menuId' => $menu->id, 'userPermissionFilter' => false, 'childDepth' => 6]) ?>

<?php Box::end() ?>

<?php $form = ActiveForm::begin() ?>

<?php Box::begin(
    [
        'title' => 'Menu Update',
        'responsive' => false,
        'tools' => [Html::tag('span', "ID: ".$menu->id."", ['class' => 'label label-default'])],
        'footer' => [
            DeleteButton::widget(['model' => $menu]),
            UpdateButton::widget(['itemName' => 'Menu'])
        ]
    ]
) ?>

<?= $this->render('_form', ['form' => $form, 'model' => $menu]) ?>

<?php Box::end() ?>

<?php ActiveForm::end() ?>

</div>
<div class="col-md-6">

<?php $form = ActiveForm::begin(); ?>

    <?php Box::begin(
        [
            'title' => 'Add New Menu Item',
            'responsive' => false,
            'footer' => [Html::submitButton(FA::icon('plus') . ' Add<span class="hidden-xs hidden-sm"> Menu Item</span>', ['class' => 'btn btn-primary'])]
        ]
    ) ?>
<?= $this->render('_formItem', ['form' => $form, 'menuItem' => $menuItem]) ?>
<?= $this->render('_formItemPosition', ['form' => $form, 'menuItem' => $menuItem, 'menu' => $menu]) ?>

<?php Box::end() ?>

<?php ActiveForm::end(); ?>

</div>
    </div>