<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use wma\widgets\ActiveForm;
use wma\widgets\buttons\AddButton;
use yii\helpers\Html;
use wma\widgets\Box;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass)) . ' - Add New') ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['wma-nav'] = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
?>

<?= "<?= " ?>Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-12">

        <?= "<?php " ?>$form = ActiveForm::begin() ?>

        <?= "<?php " ?>Box::begin(
            [
                'title' => <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass)) . ' Details') ?>,
                'responsive' => false,
                'tools' => [],
                'footer' => [AddButton::widget(['itemName' => <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>])]
            ]
        ) ?>

        <?= "<?= " ?>$this->render('_form', ['form' => $form, 'model' => $model]) ?>

        <?= "<?php " ?>Box::end() ?>

        <?= "<?php " ?>ActiveForm::end() ?>

    </div>
</div>