<?php

namespace wma\widgets;

use rmrevin\yii\fontawesome\FA;
use Yii;
use yii\helpers\Html;

class InfoBox extends \yii\base\Widget
{
    protected $_bgColor = 'green';
    protected $_icon = 'home';
    protected $_value = 1;
    protected $_name = "Info Boxe(s)";
    protected $_link;

    public function setBgColor($color) {
        if (in_array($color, ['success', 'info', 'warning', 'danger']) || in_array($color, Yii::$app->adminSettings->getbgColors())) {
            $this->_bgColor = $color;
        }
    }

    public function getBgColor() {
        return $this->_bgColor;
    }

    public function setIcon($icon) {
        if (!empty($icon) && is_string($icon)) {
            $this->_icon = $icon;
        }
    }

    public function getIcon() {
        return $this->_icon;
    }

    public function setValue($value) {
        if (is_string($value) || is_numeric($value)) {
            $this->_value = $value;
        }
    }

    public function getValue() {
        return $this->_value;
    }

    public function setName($name) {
        if (is_string($name)) {
            $this->_name = $name;
        }
    }

    public function getName() {
        return $this->_name;
    }

    public function setLink($link) {
        if (!empty($link) && is_string($link)) {
            $this->_link = $link;
        }
    }

    public function getLink() {
        return $this->_link;
    }

    public function run() {
        if (empty($this->getLink())) {
            return Html::beginTag('div', ['class' => 'info-box']) .
                Html::tag('span', FA::icon($this->getIcon()), ['class' => 'info-box-icon bg-' . $this->getBgColor()]) .
                Html::beginTag('div', ['class' => 'info-box-content']) .
                    Html::tag('span', $this->getName(), ['class' => 'info-box-text']) .
                    Html::tag('span', $this->getValue(), ['class' => 'info-box-number']) .
                Html::endTag('div') .
            Html::endTag('div');
        } else {
            return Html::beginTag('div', ['class' => 'small-box bg-' . $this->getBgColor()]) .
                Html::beginTag('div', ['class' => 'inner']) .
                    Html::tag('h3', $this->getValue()) .
                    Html::tag('p', $this->getName()) .
                Html::endTag('div') .
                Html::beginTag('div', ['class' => 'icon']) .
                    FA::icon($this->getIcon()) .
                Html::endTag('div') .
                Html::a('More Info ' . FA::icon('arrow-circle-right'), $this->getLink(), ['class' => 'small-box-footer']) .
            Html::endTag('div');
        }
    }
}