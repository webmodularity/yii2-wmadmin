<?php

namespace wma\widgets;

use yii\helpers\Html;

class Alert extends \wmc\widgets\Alert
{
    public $callout = false;

    public function getHeadingHtml()
    {
        return Html::tag('h4', parent::getIconHtml() . $this->heading, ['class' => 'alert-heading']);
    }

    public function getIconHtml() {
        return null;
    }

    public function getCloseHtml() {
        if ($this->callout) {
            $this->close = false;
        }
        return parent::getCloseHtml();
    }

    public function getContainerOptions() {
        if ($this->callout) {
            return [
                'class' => 'callout callout-' . $this->style,
                'role' => 'alert'
            ];
        } else {
            return parent::getContainerOptions();
        }
    }
}