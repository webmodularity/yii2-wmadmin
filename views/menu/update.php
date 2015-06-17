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
use rmrevin\yii\fontawesome\FA;

$this->title = "Menu: ".$menu->name."";
$this->params['breadcrumbs'][] = ['label' => 'Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Menus';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['title' => 'Menu', 'subTitle' => $menu->name, 'icon' => 'cog']) ?>

<?= Yii::$app->alertManager->render() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-6 col-lg-6"]]) ?>


<?php Widget::begin(
    [
        'id' => 'menu-list-items',
        'title' => "".$menu->name." - Items",
        'icon' => 'list',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [
            Html::tag('span', "DIVIDER", ['class' => 'label bg-color-pinkDark']),
            Html::tag('span', "HEADER", ['class' => 'label bg-color-blueLight'])
        ]
    ]
) ?>
<?php WidgetBody::begin() ?>

<?= NestedList::widget(['menuId' => $menu->id, 'userPermissionFilter' => false, 'childDepth' => 6]) ?>

<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php Widget::begin(
    [
        'id' => 'menu-update',
        'title' => 'Menu Update',
        'icon' => 'list',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [Html::tag('span', "ID: ".$menuForm->menu_id."", ['class' => 'label label-default'])]
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'smart-form']]) ?>
<?= $this->render('_form', ['form' => $form, 'model' => $menuForm]) ?>
    <footer>
        <?= UpdateButton::widget(['itemName' => 'Menu']) ?>
        <?= DeleteButton::widget(['model' => $menuForm, 'idField' => 'menu_id', 'itemName' => 'Menu']) ?>
    </footer>
<?php ActiveForm::end() ?>
<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-6 col-lg-6"]]) ?>
<?php Widget::begin(
    [
        'id' => 'menu-add-item',
        'title' => 'Add New Menu Item',
        'icon' => 'plus',
        'buttons' => ['toggle'],
        'sortable' => true
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>

<?php $form = ActiveForm::begin(); ?>
<?= $this->render('_formItem', ['form' => $form, 'model' => $menuItemForm, 'menu' => $menu]) ?>
<?= $this->render('_formItemPosition', ['form' => $form, 'model' => $menuItemForm->position, 'menu' => $menu]) ?>
    <footer>
        <?= Html::submitButton(FA::icon('plus') . ' Add<span class="hidden-xs hidden-sm"> Menu Item</span>', ['class' => 'btn btn-primary']) ?>
    </footer>
<?php ActiveForm::end(); ?>

<?php WidgetBody::end() ?>
<?php Widget::end() ?>
<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>