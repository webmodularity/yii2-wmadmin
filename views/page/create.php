<?php

use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use wma\widgets\ActiveForm;
use wma\widgets\buttons\AddButton;
use wma\widgets\NestedList;
use yii\helpers\Html;
use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;


/* @var $this yii\web\View */
/* @var $model wmf\models\Page */

$this->title = 'Add Page';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = 'Pages';
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['title' => 'Page', 'subTitle' => 'Add New', 'icon' => 'file-o']) ?>

<?= Yii::$app->alertManager->get() ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>

<?php Widget::begin(
    [
        'id' => 'page-update',
        'title' => 'Add Page',
        'icon' => 'plus-square',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => []
    ]
) ?>
<?php WidgetBody::begin(['padding' => false]) ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'smart-form']]) ?>
<?= $this->render('_form', ['form' => $form, 'page' => $page, 'pageMarkdown' => $pageMarkdown, 'pageMenuIntegration' => $pageMenuIntegration]) ?>
    <footer>
        <?= AddButton::widget(['itemName' => 'Page']) ?>
    </footer>
<?php ActiveForm::end() ?>
<?php WidgetBody::end() ?>
<?php Widget::end() ?>

<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>