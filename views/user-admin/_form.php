<fieldset>
    <div class="row">
        <?= $form->field($model->person, 'first_name')->iconPrepend('user')->label("First Name")->colSpan(6) ?>
        <?= $form->field($model->person, 'last_name')->iconPrepend('user')->label("Last Name")->colSpan(6) ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'email')->iconPrepend('envelope')->label("Email Address")->colSpan(6) ?>
        <?= $form->field($model, 'group_id')->label("User Group")->dropdownList(\wmu\models\UserGroup::getUserGroupList(Yii::$app->user->identity->group_id),
            ['options' => \wma\grid\data\UserGroupColumn::getDropdownOptions(), 'disabled' => Yii::$app->user->id === $model->id])->colSpan(6) ?>
    </div>
    <?= $form->field($model, 'status')->label("Status")->dropdownList(\wmu\models\User::getUserStatusList(),
        ['options' => \wma\grid\data\UserStatusColumn::getDropdownOptions(), 'disabled' => Yii::$app->user->id === $model->id]) ?>

    <div class="row">
        <section class="col col-xs-6">

            <label class="label">Created At</label>
            <?= Yii::$app->formatter->asDatetime($model->created_at) ?>

        </section>
        <section class="col col-xs-6">
            <label class="label">Updated At</label>
            <?= Yii::$app->formatter->asDatetime($model->updated_at) ?>
        </section>
    </div>

</fieldset>

<header>Primary Address</header>
<fieldset>
<?= $this->render('@wma/views/layouts/_address.php', [
    'form' => $form,
    'model' => $primaryAddress
]); ?>
</fieldset>