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
    const TOGGLE_ON_TEXT = "ON";
    const TOGGLE_OFF_TEXT = "OFF";

    public $template = "{label}\n{inputLabelStart}{input}{inputLabelEnd}\n{error}\n{hint}";
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

    public $_inline = false;

    /**
     * @var string The class that will be applied to the input label wrapper, set this to null to disable input label wrapper
     */
    private $_inputLabel = 'input';
    private $_inject = [
        'label' => [
            'before' => [],
            'after' => []
        ],
        'input' => [
            'before' => [],
            'after' => []
        ],
        'error' => [
            'before' => [],
            'after' => []
        ],
        'hint' => [
            'before' => [],
            'after' => []
        ]
    ];

    /**
     * @inheritdoc
     */

    public function render($content = null) {
        $this->buildTemplate();
        return parent::render($content);
    }

    /**
     * Builds final template based on assembled settings
     */

    protected function buildTemplate() {
        // Handle Label Input Wrapper
        $start = !empty($this->_inputLabel) ?  Html::beginTag('label', ['class' => $this->_inputLabel]) : '';
        $end = !empty($this->_inputLabel) ? Html::endTag('label') : '';
        $this->template = str_replace('{inputLabelStart}', $start, $this->template);
        $this->template = str_replace('{inputLabelEnd}', $end, $this->template);
        // Inject
        foreach ($this->_inject as $injectType => $inject) {
            if (count($inject['before']) > 0 || count($inject['after']) > 0) {
                $replace = "{" . $injectType . "}";
                $content = implode('', $inject['before']) . $replace . implode('', $inject['after']);
                $this->template = str_replace($replace, $content, $this->template);
            }
        }
    }

    /**
     * Attach a FontAwesome icon to end of input
     * @param null $faIconName FontAwesome icon name, without fa- (use envelope rather than fa-envelope)
     * @return $this
     */

    public function iconAppend($faIconName = null) {
        if (is_string($faIconName) && !empty($faIconName)) {
            $this->inject('input', 'before', FA::icon($faIconName, ['class' => 'icon-append']));
        }
        return $this;
    }

    public function iconPrepend($faIconName = null) {
        if (is_string($faIconName) && !empty($faIconName)) {
            $this->inject('input', 'before', FA::icon($faIconName, ['class' => 'icon-prepend']));
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
        $this->inject('input', 'after', Html::tag('b', $tooltip, ['class' => 'tooltip tooltip-' . $position]));
        $this->iconAppend('question-circle');
        return $this;
    }

    public function colSpan($colspanLength) {
        if (is_int($colspanLength)) {
            if (isset($this->options['class'])) {
                $this->options['class'] .= ' col col-' . $colspanLength;
            } else {
                $this->options['class'] = 'col col-' . $colspanLength;
            }
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
     * Modifies radioList to match SmartForm style as well as adds new cols option for displaying radios in row format
     * Also adds inline() functionality - make sure to call {{static::inline()}} BEFORE radioList!
     * @param array $items the data item used to generate the radio buttons.
     * The array values are the labels, while the array keys are the corresponding radio values.
     * @param array $options options (name => config) for the radio button list.
     * For the list of available options please refer to the `$options` parameter of [[\yii\helpers\Html::activeRadioList()]].
     * WMA specific options:
     * - cols: int Number of columns. (1,2,3,4,6,12) (Defaults to 3)
     * @return static the field object itself
     */

    public function radioList($items, $options = []) {
        // Don't wrap input in <label> tag
        $this->_inputLabel = null;
        if ($this->_inline) {
            $options['class'] = 'inline-group';
            $options['item'] = function ($index, $label, $name, $checked, $value) {
                return Html::radio($name, $checked, ['label' => $label . Html::tag('i'), 'labelOptions' => ['class' => 'radio'], 'value' => $value]);
            };
        } else {
            $cols = isset($options['cols']) && 12 % $options['cols'] == 0 ? $options['cols'] : 3;
            unset($options['cols']);
            $itemCount = count($items);
            $colSpan = 12 / $cols;
            $itemsPerCol = ceil($itemCount / $cols);
            $options['class'] = 'row';
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($colSpan, $itemCount, $itemsPerCol) {
                if ($index == 0 || $index % $itemsPerCol == 0) {
                    $out = Html::beginTag('div', ['class' => "col col-" . $colSpan . ""]);
                } else {
                    $out = '';
                }
                $out .= Html::radio($name, $checked, ['label' => $label . Html::tag('i'), 'labelOptions' => ['class' => 'radio'], 'value' => $value]);
                if ($index == ($itemCount - 1) || ($index + 1) % $itemsPerCol == 0) {
                    $out .= Html::endTag('div');
                }
                return $out;
            };
        }
        parent::radioList($items, $options);
        return $this;
    }


    public function radioToggleList($items, $options = []) {
        $this->enableClientValidation = false;
        $this->_inputLabel = null;
        $onText = isset($options['onText']) && is_string($options['onText']) ? $options['onText'] : static::TOGGLE_ON_TEXT;
        $offText = isset($options['offText']) && is_string($options['offText']) ? $options['offText'] : static::TOGGLE_OFF_TEXT;
        unset($options['onText'], $options['offText']);
        $this->adjustLabelFor($options);
        $options['item'] = function ($index, $label, $name, $checked, $value) use ($onText, $offText) {
            return Html::radio($name, $checked, ['label' => $label . Html::tag('i', '',['data-swchoff-text' => $offText, 'data-swchon-text' => $onText]), 'labelOptions' => ['class' => 'toggle'], 'value' => $value]);
        };
        parent::radioList($items, $options);
        return $this;
    }

    /**
     * Modifies checkboxList to match SmartForm style as well as adds new cols option for displaying radios in row format
     * Also adds inline() functionality - make sure to call {{static::inline()}} BEFORE checkboxList!
     * @param array $items the data item used to generate the radio buttons.
     * The array values are the labels, while the array keys are the corresponding radio values.
     * @param array $options options (name => config) for the checkbox list.
     * For the list of available options please refer to the `$options` parameter of [[\yii\helpers\Html::activeCheckboxList()]].
     * WMA specific options:
     * - cols: int Number of columns. (1,2,3,4,6,12) (Defaults to 3)
     * @return static the field object itself
     */

    public function checkboxList($items, $options = []) {
        // Don't wrap input in <label> tag
        $this->_inputLabel = null;
        if ($this->_inline) {
            $options['class'] = 'inline-group';
            $options['item'] = function ($index, $label, $name, $checked, $value) {
                return Html::checkbox($name, $checked, ['label' => $label . Html::tag('i'), 'labelOptions' => ['class' => 'checkbox'], 'value' => $value]);
            };
        } else {
            $cols = isset($options['cols']) && 12 % $options['cols'] == 0 ? $options['cols'] : 3;
            unset($options['cols']);
            $itemCount = count($items);
            $colSpan = 12 / $cols;
            $itemsPerCol = ceil($itemCount / $cols);
            $options['class'] = 'row';
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($colSpan, $itemCount, $itemsPerCol) {
                if ($index == 0 || $index % $itemsPerCol == 0) {
                    $out = Html::beginTag('div', ['class' => "col col-" . $colSpan . ""]);
                } else {
                    $out = '';
                }
                $out .= Html::checkbox($name, $checked, ['label' => $label . Html::tag('i'), 'labelOptions' => ['class' => 'checkbox'], 'value' => $value]);
                if ($index == ($itemCount - 1) || ($index + 1) % $itemsPerCol == 0) {
                    $out .= Html::endTag('div');
                }
                return $out;
            };
        }
        parent::checkboxList($items, $options);
        return $this;
    }


    public function checkboxToggleList($items, $options = []) {
        $this->enableClientValidation = false;
        $this->_inputLabel = null;
        $onText = isset($options['onText']) && is_string($options['onText']) ? $options['onText'] : static::TOGGLE_ON_TEXT;
        $offText = isset($options['offText']) && is_string($options['offText']) ? $options['offText'] : static::TOGGLE_OFF_TEXT;
        unset($options['onText'], $options['offText']);
        $this->adjustLabelFor($options);
        $options['item'] = function ($index, $label, $name, $checked, $value) use ($onText, $offText) {
            return Html::checkbox($name, $checked, ['label' => $label . Html::tag('i', '',['data-swchoff-text' => $offText, 'data-swchon-text' => $onText]), 'labelOptions' => ['class' => 'toggle'], 'value' => $value]);
        };
        parent::checkboxList($items, $options);
        return $this;
    }

    /**
     * @param $type string What {block} to inject around, (label|input|inputLabel|error|hint)
     * @param $position string before or after
     */

    protected function inject($type, $position, $code) {
        if (in_array($type, ['label', 'input', 'error', 'hint']) && in_array($position, ['before', 'after'])) {
            $this->_inject[$type][$position][] = $code;
        }
    }

    /**
     * Make sure you call this method before [[checkboxList()]] or [[radioList()]] to have any effect.
     * @return static the field object itself
     */

    public function inline() {
        $this->_inline = true;
        return $this;
    }

}