<?php

namespace wma\widgets;

class ActiveForm extends \yii\bootstrap\ActiveForm
{
    public $fieldClass = 'wma\widgets\ActiveField';
    public $validateOnBlur = false;
    public $validateOnChange = false;
}