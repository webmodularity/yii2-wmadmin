<?php

namespace wma\widgets;

use Yii;
use wmc\helpers\Html;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use rmrevin\yii\fontawesome\FA;

class Alert extends Widget
{
    public $message = null;
    public $heading = null;
    public $style = 'warning';
    public $block = false;
    public $close = true;
    public $icon = null;

    private $_closeHtml;
    private $_headingHtml;
    private $_iconHtml;
    private $_containerClass;


    public function init() {
        if (   !is_bool($this->close)
            || !is_bool($this->block)
            || !in_array($this->style, ['warning', 'success', 'info', 'danger'])
        ) {
            throw new InvalidConfigException("Invalid config settings passed to Alert Widget!");
        }

        $this->_containerClass = 'alert alert-' . $this->style;

        if ($this->block) {
            $this->_headingHtml = ($this->heading && is_string($this->heading))
                ? Html::tag('h4', $this->heading, ['class' => 'alert-heading'])
                : '';
            $this->_closeHtml = $this->close
                ? Html::a('×', "#", ['class' => 'close', 'data-dismiss' => 'alert'])
                : '';
            $this->_iconHtml = '';
            $this->_containerClass .= ' alert-block';
        } else {
            $this->_headingHtml = ($this->heading && is_string($this->heading))
                ? Html::tag('strong', $this->heading) . "&nbsp;"
                : '';
            $this->_closeHtml = $this->close
                ? Html::button('×', ['class' => 'close', 'data-dismiss' => 'alert'])
                : '';
            if ($this->icon === false) {
                $this->_iconHtml = '';
            } else if ($this->icon && is_string($this->icon)) {
                $this->_iconHtml = FA::icon($this->icon)->fixed_width();
            } else {
                // Default icon based on $this->style
                $defaultIconKey = [
                    'warning' => 'warning',
                    'success' => 'check',
                    'info' => 'info',
                    'danger' => 'times'
                ];
                $this->_iconHtml = FA::icon($defaultIconKey[$this->style])->fixed_width();
            }
        }
    }

    public function run() {
        if (!$this->message) {
            return '';
        } else {
            return Html::tag(
                'div',
                $this->_closeHtml . $this->_iconHtml . ' ' . $this->_headingHtml . $this->message,
                [
                    'class' => $this->_containerClass
                ]
            );
        }
    }
}