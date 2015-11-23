<?php
use yii\helpers\Html;
?>
<fieldset>
    <?= Html::activeHiddenInput($model, 'type') ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'icon')->hint('Name of the icon set to be used for this menu. Use abbreviation: fa for font-awesome or glyphicon for glyphicon, etc.') ?>
</fieldset>