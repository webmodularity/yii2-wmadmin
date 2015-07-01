<?php

namespace wma\widgets;

use wma\helpers\Html;
use wmc\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;

class ActiveField extends \yii\widgets\ActiveField
{
    public $template = "{label}\n{input}\n{error}\n{hint}";
    public $hintOptions = [
        'tag' => 'div',
        'class' => 'note'
    ];
    public $errorOptions = [
        'tag' => 'em',
        'class' => 'invalid'
    ];
    public $labelOptions = [
        'class' => 'label'
    ];
    public $inputOptions = [];
    public $options = [
        'tag' => 'section'
    ];

    /**
     * Unchanged from parent implementation, using to make ActiveForm::field() get wrapped in SmartAdmin styles
     */

    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            if (!isset($this->parts['{error}'])) {
                $this->error();
            }
            if (!isset($this->parts['{hint}'])) {
                $this->hint(null);
            }
            $content = strtr($this->template, $this->parts);
        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }
        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    /**
     * Attach a FontAwesome icon to end of input
     * @param null $faIconName FontAwesome icon name, without fa- (use envelope rather than fa-envelope)
     * @return $this
     */

    public function iconAppend($faIconName = null) {
        if (is_string($faIconName) && !empty($faIconName)) {
            $this->inputOptions['iconAppend'] = $faIconName;
        }
        return $this;
    }

    /**
     * Attach a FontAwesome icon to front of input
     * @param null $faIconName FontAwesome icon name, without fa- (use envelope rather than fa-envelope)
     * @return $this
     */

    public function iconPrepend($faIconName = null) {
        if (is_string($faIconName) && !empty($faIconName)) {
            $this->inputOptions['iconPrepend'] = $faIconName;
        }
        return $this;
    }

    /**
     * Add a tooltip to a text or textarea input. The content is not HTML encoded and can include icons, etc.
     * @param $content string The content of tooltip, not HTML encoded
     * @param string $position Controls tooltip placement on parent input element. The following positions are recognized:
     * top-right (default), bottom-right, right, top-left, bottom-left, left
     * @param string $iconPosition Set to either append (default) or prepend the fa-question-circle icon to parent input element
     * @return $this
     */

    public function tooltip($content, $position = 'top-right', $iconPosition = 'append') {
        $this->inputOptions['tooltip'] = compact('content', 'position', 'iconPosition');
        return $this;
    }

    /**
     * Adds grid class to field container
     * @param $cols int|array If int will add class "col col-*int*"
     * If array will be sent to {{\wma\helpers\Html::gridColsFromArray()}}
     * @return $this
     */

    public function colSpan($cols) {
        if (is_int($cols)) {
            Html::addCssClass($this->options, "col col-" . $cols . "");
        } else if (is_array($cols)) {
            Html::addGridColsClass($this->options, $cols);
        }
        return $this;
    }

    /**
     * Turns off the label above the input and sets the placeholder field of compatible inputs (text, texarea, etc.).
     * @param string|null $placeholder String to use as placeholder text for input.
     * If a null value is passed, the attribute label will be used.
     * @return $this
     */

    public function placeholder($placeholder = null) {
        if (is_null($placeholder)) {
            $this->inputOptions = ArrayHelper::merge(
                $this->inputOptions,
                ['placeholder' => $this->model->getAttributeLabel($this->attribute)]
            );
        } else if (is_string($placeholder)) {
            $this->inputOptions = ArrayHelper::merge(
                $this->inputOptions,
                ['placeholder' => $placeholder]
            );
        }
        $this->parts['{label}'] = '';
        return $this;
    }

    /**
     * Make sure you call this method before [[checkboxList()]] or [[radioList()]] to have any effect.
     * @return static the field object itself
     */

    public function inline() {
        $this->inputOptions['inline'] = true;
        return $this;
    }

    /**
     * Make sure you call this method before [[checkboxList()]] or [[radioList()]] to have any effect.
     * @return static the field object itself
     */

    public function toggle() {
        $this->enableClientValidation = false;
        $this->inputOptions['toggle'] = true;
        return $this;
    }

    public function checkboxList($items, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeCheckboxList($this->model, $this->attribute, $items, $options);
        return $this;
    }

    public function radioList($items, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeRadioList($this->model, $this->attribute, $items, $options);
        return $this;
    }

    public function input($type, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeInput($type, $this->model, $this->attribute, $options);
        return $this;
    }

    public function textInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);
        return $this;
    }

    public function passwordInput($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activePasswordInput($this->model, $this->attribute, $options);
        return $this;
    }

    public function dropDownList($items, $options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);
        return $this;
    }

}