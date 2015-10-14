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

    <?= $form->field($pageMarkdown, 'markdown')->widget(\wmc\widgets\input\SimpleMDE::className(), ['clientOptions' => [
        'toolbar' =>
            [
                'bold',
                'italic',
                'strikethrough',
                'heading',
                '|',
                'quote',
                'code',
                '|',
                'unordered-list',
                'ordered-list',
                '|',
                'link',
                'image',
                '|',
                'preview',
                'guide'
            ],
        'spellChecker' => false
    ]]) ?>
</fieldset>