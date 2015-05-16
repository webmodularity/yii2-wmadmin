<?php

namespace wma\widgets;

use wmc\helpers\Html;
use yii\helpers\ArrayHelper;
use rmrevin\yii\fontawesome\FA;

class ActiveField extends \yii\widgets\ActiveField
{
    const INVALID_CLASS = 'invalid';
    const ERROR_STATE_CLASS = 'state-error';
    const TOOLTIP_POSITIONS = 'left,right,top-left,top-right,bottom-left,bottom-right';

    public $inline = false;
    public $placeholder = null;
    public $template = "{label}\n<label class='input'>{input}</label>\n{hint}\n{error}";
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
    public $options = [
        'tag' => 'section'
    ];

    private $_inputLabelType = 'input';



    public function iconAppend($faIconName = null)
    {
        if (is_string($faIconName)) {
            $this->parts['{iconAppend}'] = FA::icon($faIconName, ['class' => 'icon-append']);
        }
        return $this;
    }

    public function iconPrepend($faIconName = null)
    {
        if (is_string($faIconName)) {
            $this->parts['{iconPrepend}'] = FA::icon($faIconName, ['class' => 'icon-prepend']);
        }
        return $this;
    }

    public function tooltip($tooltipText, $position = 'top-right', $tooltipIcon = null, $tooltipIconOptions = [])
    {
        $position = in_array($position, explode(',', self::TOOLTIP_POSITIONS)) ? $position : 'top-right';
            if (!is_null($tooltipIcon)) {
                if (!is_array($tooltipIconOptions) || count($tooltipIconOptions) < 1) {
                    // Set to default tooltip color
                    $tooltipIconOptions = ['class' => $this->form->tooltipIconColorClass];
                }
                $tooltip = FA::icon($tooltipIcon, $tooltipIconOptions) . ' ' . $tooltipText;
            } else {
                $tooltip = $tooltipText;
            }
        $this->parts['{tooltip}'] = Html::tag('b', $tooltip, ['class' => 'tooltip tooltip-' . $position]);
        return $this;
    }

    public function colSpan($colspanLength) {
        if (is_int($colspanLength)) {
            if (isset($this->options['class'])) {
                $this->options['class'] .= ' col col-' . $colspanLength;
            } else {
                $this->options['class'] = ' col col-' . $colspanLength;
            }
        }
        return $this;
    }

    public function placeholder($placeholder = null)
    {
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
     * @inheritdoc
     */

    public function radioList($items, $options = []) {
        if ($this->inline) {
            $this->template = "{label}\n{input}<i></i>\n{hint}\n{error}";
            $options['class'] = 'inline-group';
            $options['itemOptions'] = ['label' => null];
            $options['item'] = function ($index, $label, $name, $checked, $value) {
                return '<label class="radio">'
                    . Html::radio($name, $checked, ['label' => null, 'value' => $value])
                    . $label
                    . '<i></i>'
                    . '</label>';
            };
        }  elseif (!isset($options['item'])) {
            // TODO: REVIEW THIS, MAKING INLINE WORK FIRST -->
            $options['item'] = function ($index, $label, $name, $checked, $value) {
                return '<div class="radio">'
                . Html::radio($name, $checked, ['label' => $label, 'value' => $value])
                . '</div>';
            };
        }
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeRadioList($this->model, $this->attribute, $items, $options);
        return $this;
    }

    /**
     * Make sure you call this method before [[checkboxList()]] or [[radioList()]] to have any effect.
     * @param bool $value whether to render a inline list
     * @return static the field object itself
     */

    public function inline($value = true) {
    $this->inline = (bool)$value;
    return $this;
    }

}