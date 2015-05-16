<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class WidgetGrid extends \yii\base\Widget
{
    protected $_htmlOptions = [
        'id' => 'widget-grid'
    ];

    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run() {
        $content = ob_get_clean();
        return Html::tag('section', Html::tag('div', $content, ['class' => 'row']), $this->_htmlOptions);
    }
}