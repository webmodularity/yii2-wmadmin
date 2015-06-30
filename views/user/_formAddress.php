<fieldset>
    <div class="row">
        <?= $form->field($model, 'street1')->placeholder("Street Address")->colSpan(7) ?>
        <?= $form->field($model, 'street1')->placeholder("Address Line 2 (Optional)")->colSpan(4) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'city', ['options' => ['tag' => 'section', 'class' => "col col-sm-5"]])->placeholder('City')->colSpan(5) ?>
        <?= $form->field($model, 'state_id', ['options' => ['tag' => 'section', 'class' => "col col-xs-6 col-sm-3"]])->dropDownList(\wmc\models\AddressState::getStateList())->label(false) ?>
        <?= $form->field($model, 'zip', ['options' => ['tag' => 'section', 'class' => "col col-xs-6 col-sm-4"]])->placeholder('Zip') ?>
    </div>
</fieldset>