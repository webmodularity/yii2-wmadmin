<?php

use yii\helpers\Html;
use wmc\models\user\UserGroup;
use wmc\widgets\input\icons\BootstrapGlyphicons;

/* @var $this yii\web\View */
/* @var $page wmf\models\Page */
/* @var $pageMarkdown wmf\models\PageMarkdown */
/* @var $form yii\widgets\ActiveForm */
?>

<header>Page Details</header>
<fieldset>
    <div class="row">
        <?= $form->field($page, 'title')->textInput(['maxlength' => true])->label('Page Title')->colSpan(6) ?>
        <?= $form->field($page, 'name')->textInput(['maxlength' => true])->label('Page URL')->colSpan(6) ?>
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

    <div class="row">
        <?= $form->field($page, 'userGroupIds')->checkboxList(UserGroup::getAccessibleGroupList(), ['inline' => true])->label('Page Access')->colspan(6) ?>
        <?= $form->field($page, 'status')->dropDownList([0 => 'Disabled', 1 => 'Active'])->label('Page Status')->colSpan(6) ?>
    </div>
</fieldset>


<header>Menu Integration</header>
<fieldset>
    <div class="row">
        <?= $form->field($pageMenuIntegration, 'active')->checkboxList([1 => 'Appear on Site Menu'], ['toggle' => true, 'toggleOnText' => 'YES', 'toggleOffText' => 'NO'])->label('&nbsp;')->colSpan(4) ?>
        <?= $form->field($pageMenuIntegration, 'iconName')->widget(BootstrapGlyphicons::classname())->colSpan(4)->label('Icon') ?>
    </div>
</fieldset>