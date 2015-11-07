<?php
use wmc\models\Menu;
use wmc\models\user\UserGroup;
?>
<fieldset>
    <div class="row">
        <?= $form->field($menuItem, 'name')->tooltip('Name is required for Link and Header types but ignored for Divider.')->colSpan(6) ?>
        <?= $form->field($menuItem, 'type')->inline()->radioList([Menu::TYPE_LINK => 'Link', Menu::TYPE_HEADER => 'Header', Menu::TYPE_DIVIDER => 'Divider'])->colSpan(6) ?>
    </div>
    <div class="row">
        <?= $form->field($menuItem, 'icon')->tooltip('Icon Name should contain ONLY the name of the icon without the leading icon-set. Use "home" rather than "fa-home". Ignored for Divider type and is optional for Link and Header.')->colSpan(6) ?>
        <?= $form->field($menuItem, 'link')->tooltip('Link is required for Link type but ignored for Header and Divider.')->colSpan(6) ?>
    </div>
</fieldset>
<fieldset>
    <?= $form->field($menuItem, 'userGroupIds')->checkboxList(UserGroup::getAccessibleGroupList(), ['cols' => 2])->label('User Groups') ?>
</fieldset>