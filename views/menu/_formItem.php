<?php
use wmc\models\Menu;
use wmc\models\user\UserGroup;
?>
<fieldset>
    <div class="row">
        <?= $form->field($menuItem, 'name')->hint('Name is required for Link and Header types but ignored for Divider.')->colSpan(6) ?>
        <?= $form->field($menuItem, 'type')->inline()->radioList([Menu::TYPE_LINK => 'Link', Menu::TYPE_HEADER => 'Header', Menu::TYPE_DIVIDER => 'Divider'])->colSpan(6) ?>
    </div>
    <div class="row">
        <?= $form->field($menuItem, 'icon')->hint('Use "home" rather than "fa-home". Ignored for Divider type and is optional for Link and Header.')->colSpan(6) ?>
        <?= $form->field($menuItem, 'link')->hint('Link is required for Link type but ignored for Header and Divider.')->colSpan(6) ?>
    </div>
</fieldset>
<fieldset>
    <?= $form->field($menuItem, 'userGroupIds')->inline()->checkboxList(UserGroup::getAccessibleGroupList(), ['cols' => 2])->label('User Groups') ?>
</fieldset>