<?php

namespace wma\widgets;

use wma\helpers\Html;

class InputTooltip extends \yii\base\Widget
{
    public $position = 'top-right';
    public $content = "Tooltip Text";

    private $_positions = ['left', 'right', 'top-left' , 'top-right', 'bottom-left', 'bottom-right'];

    public function init() {
        if (!in_array($this->position, $this->_positions)) {
            $this->position = 'top-right';
        }
    }

    public function run() {
        return Html::tag('b', $this->content, ['class' => 'tooltip tooltip-' . $this->position]);
    }
}