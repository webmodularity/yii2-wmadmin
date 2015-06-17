<?php

use kartik\select2\Select2;

?>
<fieldset>
    <div class="row">
        <?= $form->field($model, 'insert_type')->radioToggleList($model->insertTypeOptions)->colSpan(6)->label('Attach Via:') ?>
        <?= $form->field($model, 'item_id')->widget(Select2::classname(), [
            'data' => $menu->menuItemList,
            'theme' => 'bootstrap',
            'options' => ['placeholder' => 'Select a Menu Item'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->colSpan(6)->label('Attach To:') ?>
    </div>
</fieldset>