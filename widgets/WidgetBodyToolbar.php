<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class WidgetBodyToolbar extends \yii\base\Widget
{
    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run() {
        $content = ob_get_clean();
        return Html::tag('div', $content, ['class' => 'widget-body-toolbar']);
    }
}