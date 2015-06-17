<fieldset>
    <div class="row">
        <?= $form->field($model, 'name')->tooltip('Name is required for Link and Header types but ignored for Divider.', 'top-right', 'info-circle')->colSpan(6) ?>
        <?= $form->field($model, 'type')->inline()->radioList($model->typeOptions)->colSpan(6) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'icon')->tooltip('Icon Name should contain ONLY the name of the icon without the leading icon-set. Use "home" rather than "fa-home". Ignored for Divider type and is optional for Link and Header.', 'top-right', 'info-circle')->colSpan(6) ?>
        <?= $form->field($model, 'link')->tooltip('Link is required for Link type but ignored for Header and Divider.','top-right', 'info-circle')->colSpan(6) ?>
    </div>
</fieldset>
<fieldset>
    <?= $form->field($model, 'user_groups')->checkboxList(\wmu\models\UserGroup::getUserGroupList(), ['cols' => 2]) ?>
</fieldset>