<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class WidgetBody extends \yii\base\Widget
{
    protected $_padding = true;
    protected $_editbox = '';
    protected $_content;
    protected $_wrap = true;

    public function setPadding($padding) {
        if ($padding === false) {
            $this->_padding = false;
        }
    }

    /**
     * HTML to be placed in jarviswidget-editbox div inside body
     * Example: (Create a [hidden] text input to change widget title that reacts to edit button
     * <!-- This area used as dropdown edit box -->
     * <input class="form-control" type="text">
     * <span class="note"><i class="fa fa-check text-success"></i> Change title to update and save instantly!</span>
     * @param $editboxContent string HTML to be placed in jarviswidget-editbox div inside body
     */

    public function setEditbox($editboxContent) {
        if (!empty($editboxContent) && is_string($editboxContent)) {
            $this->_editbox = $editboxContent;
        }
    }

    /**
     * If used as WidgetBody::widget() this will be used as body content
     * @param $content string Body content
     */

    public function setContent($content) {
        $this->_content = $content;
    }

    /**
     * Set this to false to turn off the container div tag
     * @param $wrap bool Include default div wrapper
     */

    public function setWrap($wrap) {
        if (is_bool($wrap)) {
            $this->_wrap = $wrap;
        }
    }

    public function init()
    {
        parent::init();
        if (empty($this->_content)) {
            ob_start();
        }
    }

    public function run() {
        if (empty($this->_content)) {
            $content = ob_get_clean();
        } else {
            $content = $this->_content;
        }
        $bodyParts = [];
        if ($this->_wrap === true) {
            $bodyParts[] = Html::beginTag('div');
        }
        $bodyParts[] = $this->getEditboxHtml();
        $bodyParts[] = Html::tag('div', $content, $this->getWidgetBodyHtmlOptions());
        if ($this->_wrap === true) {
            $bodyParts[] = Html::endTag('div');;
        }
        return implode('', $bodyParts);
    }

    protected function getWidgetBodyHtmlOptions() {
        return $this->_padding === false ? ['class' => 'widget-body no-padding'] : ['class' => 'widget-body'];
    }

    protected function getEditboxHtml() {
        return Html::beginTag('div', ['class' => 'jarviswidget-editbox'])
        . $this->_editbox
        . Html::endTag('div');
    }
}