<?php
use wmc\models\user\UserGroup;
?>
<fieldset>
    <div class="row">
        <?= $form->field($model->person, 'first_name')->iconPrepend('user')->label("First Name")->colSpan(6) ?>
        <?= $form->field($model->person, 'last_name')->iconPrepend('user')->label("Last Name")->colSpan(6) ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'email')->iconPrepend('envelope')->label("Email Address")->colSpan(['xs' => 12, 'sm' => 6]) ?>
        <?= $form->field($model->person->phone, 'full')->widget('yii\widgets\MaskedInput',
            [
                'options' => ['placeholder' => 'Phone', 'iconPrepend' => 'phone'],
                'mask' => "(999)999-9999"
            ]
        )->label('Phone (Optional)')->colspan(['xs' => 6, 'sm' => 4]) ?>
        <?= $form->field($model->person->phone, 'type_id')->dropDownList([
                \wmc\models\Phone::TYPE_MOBILE => 'Mobile',
                \wmc\models\Phone::TYPE_HOME => 'Home',
                \wmc\models\Phone::TYPE_OFFICE => 'Office'
            ]
        )->label('&nbsp;')->colspan(['xs' => 6, 'sm' => 2]) ?>
    </div>

    <div class="row">
        <?= $form->field($model, 'group_id')->label("User Group")->dropdownList(UserGroup::getUserGroupList(Yii::$app->user->identity->group_id, [UserGroup::GUEST]),
            ['options' => \wma\grid\data\UserGroupColumn::getDropdownOptions(), 'disabled' => Yii::$app->user->id === $model->id])->colSpan(6) ?>
        <?= $form->field($model, 'status')->label("Status")->dropdownList(\wmc\models\user\User::getUserStatusList(),
            ['options' => \wma\grid\data\UserStatusColumn::getDropdownOptions(), 'disabled' => Yii::$app->user->id === $model->id])->colSpan(6) ?>
    </div>


</fieldset>

<header>Address (Optional)</header>
<fieldset>
<?= $this->render('@wma/views/layouts/_address.php', [
    'form' => $form,
    'model' => $model->person->primaryAddress
]); ?>
</fieldset>