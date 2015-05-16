<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class WidgetBody extends \yii\base\Widget
{
    protected $_padding = true;
    protected $_editbox = '';

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

    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run() {
        $content = ob_get_clean();
        return Html::beginTag('div')
            . $this->getEditboxHtml()
            . Html::tag('div', $content, $this->getWidgetBodyHtmlOptions())
        . Html::endTag('div');
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