<?php

use kartik\select2\Select2;
use wmc\behaviors\NestedSetsBehavior;

?>
<fieldset>
    <div class="row">
        <?= $form->field($menuItem, 'attachOperation')->radioList(
            [
                NestedSetsBehavior::OPERATION_INSERT_BEFORE => 'Before',
                NestedSetsBehavior::OPERATION_INSERT_AFTER => 'After',
                NestedSetsBehavior::OPERATION_PREPEND_TO => 'Prepend',
                NestedSetsBehavior::OPERATION_APPEND_TO => 'Append'

            ]
        )->colSpan(6)->label('Attach Via:') ?>
        <?= $form->field($menuItem, 'attachTargetId')->widget(Select2::classname(), [
            'data' => $menu->menuItemList,
            'theme' => 'bootstrap',
            'options' => ['placeholder' => 'Select a Menu Item'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->colSpan(6)->label('Attach To:') ?>
    </div>
</fieldset>