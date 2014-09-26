<?php

namespace wmadmin\widgets;

use yii\helpers\ArrayHelper;

class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        $mergeConfig = [
            'options' => [
                'role' => 'form',
                'class' => 'smart-form'
            ],
            'requiredCssClass' => '',
            'errorCssClass' => 'state-error',
            'successCssClass' => 'state-success',
            'fieldClass' => 'wmadmin\widgets\ActiveField'
        ];

        $config = ArrayHelper::merge($mergeConfig, $config);
        return parent::__construct($config);
    }
}