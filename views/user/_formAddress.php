<fieldset>
    <div class="row">
        <?= $form->field($model, 'street1')->placeholder("Street Address")->colSpan(['xs' => 6, 'sm' => 7, 'md' => 12, 'lg' => 7]) ?>
        <?= $form->field($model, 'street2')->placeholder("Address Line 2 (Optional)")->colSpan(['xs' => 6, 'sm' => 5, 'md' => 12, 'lg' => 5]) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'city')->placeholder('City')->colSpan(['xs' => 12, 'sm' => 5]) ?>
        <?= $form->field($model, 'state_id')->dropDownList(\wmc\models\AddressState::getStateList())->label(false)->colSpan(['xs' => 6, 'sm' => 3]) ?>
        <?= $form->field($model, 'zip', ['options' => ['tag' => 'section', 'class' => "col col-xs-6 col-sm-4"]])->placeholder('Zip')->colSpan(['xs' => 6, 'sm' => 4]) ?>
    </div>
</fieldset>