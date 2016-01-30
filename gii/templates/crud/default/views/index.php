<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use wma\grid\ActionColumn;
use wma\widgets\Box;
use <?= $generator->indexWidgetType === 'grid' ? "wma\\grid\\GridView" : "wma\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$addText = 'Add New ' . <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
?>
<?= "<?= " ?>Ribbon::widget() ?>

<?= "<?php " ?>ContentContainer::begin() ?>

<?= "<?= " ?>PageTitle::widget(['subTitle' => '', 'icon' => '']) ?>

<?= "<?= " ?>Yii::$app->alertManager->get() ?>

<?= "<?php " ?>WidgetGrid::begin() ?>
<?= "<?php " ?>WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>
<?= "<?php " ?>Widget::begin(
    [
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-list-all',
        'title' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>,
        'icon' => '',
        'buttons' => ['toggle'],
        'sortable' => true,
        'toolbars' => [
            Html::a(FA::icon('plus') . ' ' . 'Add ' . <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success'])
        ]
    ]
) ?>
<?= "<?= "?>WidgetBodyGridView::widget([
        'bodyOptions' => [
            'padding' => false
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'wma\grid\SerialColumn'],
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
            ['class' => 'wma\grid\ActionUserAdminColumn'],
        ],
    ]); ?>
<?= "<?php " ?>Widget::end() ?>

<?= "<?php " ?>WidgetContainer::end() ?>

<?= "<?php " ?>WidgetGrid::end() ?>

<?= "<?php " ?>ContentContainer::end() ?>