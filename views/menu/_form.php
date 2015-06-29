<fieldset>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'icon')->tooltip('This field should contain the name of the icon set that will be used when an icon is specified for a menu item. So use fa for font-awesome or glyphicon for glyphicon.') ?>
</fieldset>