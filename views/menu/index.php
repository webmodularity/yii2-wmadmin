<?php

use wmc\helpers\Html;
use yii\grid\GridView;
use wma\widgets\Ribbon;
use wma\widgets\Widget;
use wma\widgets\WidgetBody;
use wma\widgets\WidgetGrid;
use wma\widgets\WidgetContainer;
use wma\widgets\Alert;
use wma\widgets\PageTitle;
use wma\widgets\ContentContainer;
use wma\widgets\ActiveForm;

$this->title = 'Menu Builder';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Ribbon::widget() ?>

<?php ContentContainer::begin() ?>

<?= PageTitle::widget(['subTitle' => 'Admin Menu Builder', 'icon' => 'cog']) ?>

<?php WidgetGrid::begin() ?>
<?php WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-6 col-lg-6"]]) ?>
<?php Widget::begin(
    [
        'id' => 'menu-list-all',
        'title' => 'Menu Items',
        'icon' => 'list',
        'buttons' => ['toggle'],
        'sortable' => true
    ]
) ?>
<?php WidgetBody::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'menu_id',
            'type',
            //'lft',
            //'rgt',
            // 'depth',
             'name',
             'link',
             'icon',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
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
<fieldset>
    <?= $form->field($model, 'child_of') ?>
    <?= $form->field($model, 'type') ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'link') ?>
    <?= $form->field($model, 'icon') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
</fieldset>
<?php ActiveForm::end(); ?>

<?php WidgetBody::end() ?>
<?php Widget::end() ?>
<?php WidgetContainer::end() ?>

<?php WidgetGrid::end() ?>

<?php ContentContainer::end() ?>