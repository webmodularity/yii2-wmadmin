<?php
use wmc\models\user\UserGroup;
?>
<div class="row">
    <?= $form->field($model->person, 'first_name')->label("First Name")->colSpan(6) ?>
    <?= $form->field($model->person, 'last_name')->label("Last Name")->colSpan(6) ?>
</div>

<div class="row">
    <?= $form->field($model, 'email')->label("Email Address")->colSpan(['xs' => 12, 'sm' => 6]) ?>
    <?= $form->field($model->person->phone, 'full')->widget('yii\widgets\MaskedInput',
        [
            'options' => ['placeholder' => 'Phone', 'class' => 'form-control'],
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
    <?= $form->field($model, 'group_id')->label("User Group")->dropdownList(UserGroup::getAccessibleGroupList(null, [UserGroup::GUEST]),
        ['options' => \wma\grid\data\UserGroupColumn::getDropdownOptions(), 'disabled' => Yii::$app->user->id === $model->id])->colSpan(6) ?>
    <?= $form->field($model, 'status')->label("Status")->dropdownList(\wmc\models\user\User::getUserStatusList(),
        ['options' => \wma\grid\data\UserStatusColumn::getDropdownOptions(), 'disabled' => Yii::$app->user->id === $model->id])->colSpan(6) ?>
</div>

<h4>Address (Optional)</h4>

<?= $this->render('@wma/views/layouts/_address.php', [
    'form' => $form,
    'model' => $model->person->primaryAddress
]); ?>