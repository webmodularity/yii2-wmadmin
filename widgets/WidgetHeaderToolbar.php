<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class WidgetHeaderToolbar extends \yii\base\Widget
{
    public $toolbar = '';

    public function run() {
        return Html::tag('div', $this->toolbar, ['class' => 'widget-toolbar']);
    }
}