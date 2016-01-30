<?php

use yii\helpers\Html;
use wmc\models\user\UserGroup;
use wmc\widgets\input\icons\BootstrapGlyphicons;

/* @var $this yii\web\View */
/* @var $page wmf\models\Page */
/* @var $pageMarkdown wmf\models\PageMarkdown */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <?= $form->field($page, 'title')->textInput(['maxlength' => true])->label('Page Title')->colSpan(4) ?>
    <?= $form->field($page, 'name')->textInput(['maxlength' => true])->label('Page URL')->colSpan(4) ?>
    <?= $form->field($page, 'status')->dropDownList([0 => 'Disabled', 1 => 'Active'])->label('Page Status')->colSpan(4) ?>
</div>

<div class="row">
    <?= $form->field($page, 'userGroupIds')->inline()->checkboxList(UserGroup::getAccessibleGroupList())->label('User Group Access')->colspan(12) ?>
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