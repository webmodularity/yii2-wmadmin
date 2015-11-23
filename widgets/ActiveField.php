<?php

namespace wma\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;

class ActiveField extends \yii\bootstrap\ActiveField
{

    /**
     * Adds grid class to field container
     * @param $cols int|array If int will add class "col col-*int*"
     * If array will be sent to {{\wma\helpers\Html::gridColsFromArray()}}
     * @return $this
     */

    public function colSpan($cols) {
        if (is_int($cols)) {
            Html::addCssClass($this->options, "col-md-" . $cols . "");
        } else if (is_array($cols)) {
            Html::addGridColsClass($this->options, $cols);
        }
        return $this;
    }

    /**
     * Sets the placeholder field of compatible inputs (text, texarea, etc.). This must be called before the input
     * method. This is correct: placeholder()->input() while input()->placeholder() will not work.
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
        return $this;
    }

    public function feedbackIcon($iconName) {
        Html::addCssClass($this->options, 'has-feedback');
        $icon = FA::icon($iconName, ['class' => 'form-control-feedback'])->tag('span');
        $this->template = str_replace('{input}', '{input}' . $icon, $this->template);

        return $this;
    }
}