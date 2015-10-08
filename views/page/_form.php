<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $page wmf\models\Page */
/* @var $pageMarkdown wmf\models\PageMarkdown */
/* @var $form yii\widgets\ActiveForm */
?>

<fieldset>
    <div class="row">
        <?= $form->field($page, 'title')->textInput(['maxlength' => true])->colSpan(4) ?>

        <?= $form->field($page, 'name')->textInput(['maxlength' => true])->colSpan(4) ?>

        <?= $form->field($page, 'status')->dropDownList(    [0 => 'Disabled', 1 => 'Active'])->colSpan(4) ?>
    </div>

    <?= $form->field($pageMarkdown, 'markdown')->textarea(['rows' => 6]) ?>

    <?= $form->field($page, 'layout')->textInput(['maxlength' => true]) ?>
</fieldset>