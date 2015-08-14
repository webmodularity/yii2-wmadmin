<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

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
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('Update {modelClass}: ', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?> . ' ' . $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update: ') ?> . $model-><?= $generator->getNameAttribute() ?>;
?>
<?= "<?= " ?>Ribbon::widget() ?>

<?= "<?php " ?>ContentContainer::begin() ?>

<?= "<?= " ?>PageTitle::widget(['title' => <?= $generator->generateString('Update {modelClass}', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?>, 'subTitle' => $model-><?= $generator->getNameAttribute() ?>, 'icon' => 'edit']) ?>

<?= "<?= " ?>Yii::$app->alertManager->get() ?>

<?= "<?php " ?>WidgetGrid::begin() ?>
<?= "<?php " ?>WidgetContainer::begin(['htmlOptions' => ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"]]) ?>

<?= "<?php "?>Widget::begin(
[
'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update',
'title' => <?= $generator->generateString('Update ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>,
'icon' => 'edit',
'buttons' => ['toggle'],
'sortable' => true,
'toolbars' => [Html::tag('span', "ID: ".$model->id."", ['class' => 'label label-default'])]
]
) ?>
<?= "<?php " ?>WidgetBody::begin(['padding' => false]) ?>

<?= "<?php " ?>$form = ActiveForm::begin(['options' => ['class' => 'smart-form']]) ?>
<?= "<?= " ?>$this->render('_form', ['form' => $form, 'model' => $model]) ?>
<footer>
    <?= "<?= " ?>UpdateButton::widget(['itemName' =>  <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>]) ?>
    <?= "<?= " ?>DeleteButton::widget(['model' => $model]) ?>
</footer>
<?= "<?php " ?>ActiveForm::end() ?>
<?= "<?php " ?>WidgetBody::end() ?>
<?= "<?php " ?>Widget::end() ?>

<?= "<?php " ?>WidgetContainer::end() ?>

<?= "<?php " ?>WidgetGrid::end() ?>

<?= "<?php " ?>ContentContainer::end() ?>
