<?php

namespace wma\widgets;

use Yii;
use wma\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * Modal window with form adapted from {{\yii\bootstrap\Modal}}
 */

class ModalForm extends \yii\bootstrap\Modal
{
    /**
     * @var string|null Set this as a shortcut to $header = <h4 class="modal-title">{headerText}</h4>
     */
    public $headerText = null;
    /**
     * @var string|null Change the text for submit button
     */
    public $submitText = 'Submit';
    /**
     * @var array Options to pass to ActiveForm::begin()
     */
    public $formOptions = [];

    protected $_beginHtml = '';
    protected $_form = null;

    public function getForm() {
        return $this->_form;
    }

    /**
     * Initializes the widget.
     */
    public function init() {
        // Header
        if (!empty($this->headerText)) {
            $this->header = Html::tag('h4', $this->headerText, ['class' => "modal-title"]);
        }
        // Footer
        if (empty($this->footer)) {
            $this->footer = Html::submitButton($this->submitText, ['class' => 'btn btn-primary']);
        }
        $this->initOptions();
        // Ugly workaround to call init method on \yii\bootstrap\Widget while bypassing Modal::init()
        \yii\bootstrap\Widget::init();
        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-dialog ' . $this->size]) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-content']) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
        $this->_form = ActiveForm::begin($this->formOptions);
        ob_start();
    }
    /**
     * Renders the widget.
     */
    public function run() {
        echo ob_get_clean();
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        ActiveForm::end();
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-dialog
        echo "\n" . Html::endTag('div');
        $this->registerPlugin('modal');
    }
}