<div class="row">
    <?= $form->field($model, 'street1')->placeholder("Street Address")->label(false)->colSpan(['xs' => 6, 'sm' => 7, 'md' => 12, 'lg' => 7]) ?>
    <?= $form->field($model, 'street2')->placeholder("Address Line 2 (Optional)")->label(false)->colSpan(['xs' => 6, 'sm' => 5, 'md' => 12, 'lg' => 5]) ?>
</div>
<div class="row">
    <?= $form->field($model, 'city')->placeholder('City')->colSpan(['xs' => 12, 'sm' => 5])->label(false) ?>
    <?= $form->field($model, 'state_id')->dropDownList(\wmc\models\AddressState::getStateList(), ['prompt' => ''])->label(false)->colSpan(['xs' => 6, 'sm' => 3])->label(false) ?>
    <?= $form->field($model, 'zip')->placeholder('Zip')->colSpan(['xs' => 6, 'sm' => 4])->label(false) ?>
</div>