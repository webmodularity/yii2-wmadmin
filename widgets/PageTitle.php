<?php

/**
 * Needs functionality, currently displays dummy content
 */

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;

class PageTitle extends \yii\base\Widget
{
    protected $_title = null;
    protected $_subTitle = null;
    protected $_titleColor = 'txt-color-blueDark';
    protected $_icon = null;
    protected $_toolbar = null;

    public function setTitle($title) {
        if (is_string($title)) {
            $this->_title = $title;
        }
    }

    public function setSubTitle($subTitle) {
        if (!empty($subTitle)) {
            $this->_subTitle = $subTitle;
        }
    }

    public function setIcon($iconName) {
        if (is_string($iconName)) {
            $this->_icon = $iconName;
        }
    }

    public function setTitleColor($titleColor) {
        // Maybe check this for valid SmartAdmin color?
        if (is_string($titleColor)) {
            $this->_titleColor = $titleColor;
        }
    }

    /**
     * @param $toolbarHtml string HTML code (graphs, charts, etc.) that are place on right side of pageTitle row
     */

    public function setToolbar($toolbarHtml) {
        if (!empty($toolbarHtml)) {
            $this->_toolbar = $toolbarHtml;
        }
    }

    public function init() {
        parent::init();
        if (is_null($this->_title)) {
            $this->_title = $this->view->title;
        }
    }

    public function run()
    {
        return Html::beginTag('div', ['class' => 'row'])
            . Html::beginTag('div', ['class' => "col-xs-12 col-sm-7 col-md-7 col-lg-4"])
                . Html::beginTag('h1', $this->getHtmlOptions())
                    . $this->getIconHtml()
                    . Html::encode($this->_title)
                    . $this->getSubTitleHtml()
                . Html::endTag('h1')
            . Html::endTag('div')
            . Html::beginTag('div', ['class' => "col-xs-12 col-sm-5 col-md-5 col-lg-8"])
                . $this->getToolbarHtml()
            . Html::endTag('div')
        . Html::endTag('div');
    }

    protected function getHtmlOptions() {
        return [
            'class' => 'page-title ' . $this->_titleColor
        ];
    }

    protected function getIconHtml() {
        if (!empty($this->_icon)) {
            return FA::icon($this->_icon)->fixedWidth() . ' ';
        }
        return ' ';
    }

    protected function getSubTitleHtml() {
        if (!empty($this->_subTitle)) {
            return ' ' . Html::tag('span', '> ' . $this->_subTitle);
        }
        return '';
    }

    protected function getToolbarHtml() {
        if (!empty($this->_toolbar)) {
            return $this->_toolbar;
        }
        return '';
    }

}