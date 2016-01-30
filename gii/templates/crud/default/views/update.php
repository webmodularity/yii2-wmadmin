<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use wma\widgets\ActiveForm;
use wma\widgets\UpdateButton;
use yii\helpers\Html;
use wma\widgets\Box;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString('{modelClass}: ', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?> . $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $model-><?= $generator->getNameAttribute() ?>;
?>

<?= "<?= " ?>Yii::$app->alertManager->get() ?>

<div class="row">
    <div class="col-md-12">

        <?= "<?php "?>$form = ActiveForm::begin() ?>

        <?= "<?php " ?>Box::begin(
            [
                'title' => <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass)) . ' Details') ?>,
                'responsive' => false,
                'tools' => [
                    Html::tag('span', "ID: ".$model->id."", ['class' => 'label label-primary'])
                ],
                'footer' => [
                    UpdateButton::widget(['itemName' => <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>])
                ]
            ]
        ) ?>

            <?= "<?= " ?>$this->render('_form', ['form' => $form, 'model' => $model]) ?>

        <?= "<?php " ?>Box::end() ?>

        <?= "<?php " ?>ActiveForm::end() ?>

    </div>
</div>