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
use yii\helpers\Html;
use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $page wmf\models\Page */

$this->title = 'Update Page: ' . ' ' . $page->name;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update: ' . $page->name;
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['title' => 'Update Page', 'subTitle' => $page->name, 'icon' => 'edit']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>

<?php Widget::begin(
    [
        'id' => 'page-update',
        'title' => 'Update Page',
        'icon' => 'edit',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [Html::tag('span', "ID: ".$page->id."", ['class' => 'label label-default'])]
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'smart-form']]) ?>
<?= $this->render('_form', ['form' => $form, 'page' => $page, 'pageMarkdown' => $pageMarkdown]) ?>
    <footer>
        <?= UpdateButton::widget(['itemName' =>  'Page', 'updateText' => 'Publish']) ?>
        <?= DeleteButton::widget(['model' => $page]) ?>
    </footer>
<?php ActiveForm::end() ?>
<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>