<?php

namespace yii\helpers;

use rmrevin\yii\fontawesome\FA;
//use wmc\helpers\ArrayHelper;

class Html extends \yii\helpers\BaseHtml
{

    public static function addGridColsClass(&$options, $gridCols) {
        if (is_array($gridCols) && is_array($options) && !empty($gridCols)) {
            $class = ['col'];
            $validSizes = ['xs', 'sm', 'md', 'lg'];

            if (!ArrayHelper::isAssociative($gridCols)) {
                $keyedCols = [];
                foreach ($validSizes as $size) {
                    $next = array_shift($gridCols);
                    if (!is_null($next) && is_int($next) && $next > 0) {
                        $keyedCols[$size] = $next;
                    }
                }
            } else {
                $keyedCols = [];
                foreach ($validSizes as $size) {
                    $val = isset($gridCols[$size]) ? $gridCols[$size] : null;
                    if (!is_null($val) && is_int($val) && $val > 0) {
                        $keyedCols[$size] = $val;
                    }
                }
            }

            foreach ($keyedCols as $size => $val) {
                $class[] = "col-" . $size . "-" . $val . "";
            }

            static::addCssClass($options, implode(' ', $class));
        }
    }

    /**
     * Adds SmartAdmin styling
     */

    public static function textarea($name, $value = '', $options = [])
    {
        $labelOptions = ['class' => 'textarea'];
        if (isset($options['disabled']) && $options['disabled']) {
            static::addCssClass($labelOptions, 'state-disabled');
        }
        return static::tag('label',  parent::textarea($name, $value, $options), $labelOptions);
    }

    /**
     * Adds SmartAdmin styling
     */

    public static function dropDownList($name, $selection = null, $items = [], $options = []) {
        $labelOptions = ['class' => 'select'];
        if (isset($options['disabled']) && $options['disabled']) {
            static::addCssClass($labelOptions, 'state-disabled');
        }
        return static::tag('label',  parent::dropDownList($name, $selection, $items, $options). static::tag('i', ''), $labelOptions);
    }

    /**
     * Add SmartAdmin styling and expand functionality via $options[]
     * - $options['tooltip'] string|array If this is a string it will be used as the tooltipContent (not HTML encoded)
     * If this is an array the following keys are recognized:
     * -- content string The tooltip content (not HTML encoded - can use icons, etc.)
     * -- position string Controls tooltip placement on parent input element. The following positions are recognized:
     * top-right (default), bottom-right, right, top-left, bottom-left, left
     * -- iconPosition string Set to either append (default) or prepend the fa-question-circle icon to parent input element
     * - $options['iconAppend'] string The fontawesome icon name (name only without leading fa-) to append to parent input element
     * - $options['iconPrepend'] string The fontawesome icon name (name only without leading fa-) to prepend to parent input element
     */

    public static function input($type, $name = null, $value = null, $options = []) {
        $tooltip = $icon = $begin = $end = '';
        $iconTypes = ['text', 'password', 'email'];
        if (in_array($type, $iconTypes)) {
            $labelOptions = ['class' => 'input'];
            if (isset($options['disabled']) && $options['disabled']) {
                static::addCssClass($labelOptions, 'state-disabled');
            }
            if (isset($options['tooltip'])) {
                // Tooltips
                $tooltipPosition = 'top-right';
                $tooltipIconPosition = 'append';
                $tooltipContent = "Tooltip text!";
                if (is_string($options['tooltip'])) {
                    $tooltipContent = $options['tooltip'];
                } else if (is_array($options['tooltip'])) {
                    if (isset($options['tooltip']['content'])) {
                        $tooltipContent = $options['tooltip']['content'];
                    }
                    if (isset($options['tooltip']['position'])) {
                        $tooltipPosition = $options['tooltip']['position'];
                    }
                    if (isset($options['tooltip']['iconPosition'])) {
                        $tooltipIconPosition = $options['tooltip']['iconPosition'];
                    }
                }
                $tooltip = static::tag('b', $tooltipContent, ['class' => 'tooltip tooltip-' . $tooltipPosition]);
                if (!isset($options["icon".ucfirst($tooltipIconPosition).""])) {
                    $options["icon".ucfirst($tooltipIconPosition).""] = 'question-circle';
                }
                unset($options['tooltip']);
            }
            $iconAttach = ['append', 'prepend'];
            foreach ($iconAttach as $attach) {
                if (isset($options["icon".ucfirst($attach).""])) {
                    $icon .= FA::icon($options["icon".ucfirst($attach).""], ['class' => "icon-".$attach.""]);
                    unset($options["icon".ucfirst($attach).""]);
                }
            }

            $begin = static::beginTag('label', $labelOptions) . $icon;
            $end = $tooltip . static::endTag('label');
        }

        return $begin . parent::input($type, $name, $value, $options) . $end;
    }

    /**
     * Add SmartAdmin styling and expand functionality via $options[]
     * - $options['toggle'] bool Set to true to generate toggle switches instead of radio button (Defaults to false)
     * - $options['toggleOnText'] string The text used to signify switch is checked (ON, YES, TRUE, etc.) (Defaults to ON)
     * - $options['toggleOffText'] string The text used to signify switch is NOT checked (OFF, NO, FALSE, etc.) (Defaults to OFF)
     * - $options['inline'] bool Set to true to have radio options appear on same line (Defaults to false)
     * - $options['cols'] int If inline is set to false, radioList will be displayed in 12 col grid (Must be 1,2,3,4,6,12 - Defaults to 1)
     */

    public static function radioList($name, $selection = null, $items = [], $options = []) {
        $toggle = isset($options['toggle']) && $options['toggle'] === true ? true : false;
        $inline = isset($options['inline']) && $options['inline'] === true ? true : false;
        if ($toggle) {
            $onText = isset($options['toggleOnText']) && is_string($options['toggleOnText']) ? $options['toggleOnText'] : "ON";
            $offText = isset($options['toggleOffText']) && is_string($options['toggleOffText']) ? $options['toggleOffText'] : "OFF";
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($onText, $offText) {
                return static::radio($name, $checked, ['label' => $label . static::tag('i', '',['data-swchoff-text' => $offText, 'data-swchon-text' => $onText]), 'labelOptions' => ['class' => 'toggle'], 'value' => $value]);
            };
        } else if ($inline) {
            static::addCssClass($options, 'inline-group');
            $options['item'] = function ($index, $label, $name, $checked, $value) {
                return static::radio($name, $checked, ['label' => $label . static::tag('i'), 'labelOptions' => ['class' => 'radio'], 'value' => $value]);
            };
        } else {
            $cols = isset($options['cols']) && 12 % $options['cols'] == 0 ? $options['cols'] : 1;
            $itemCount = count($items);
            $colSpan = 12 / $cols;
            $itemsPerCol = ceil($itemCount / $cols);
            static::addCssClass($options, 'row');
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($colSpan, $itemCount, $itemsPerCol) {
                if ($index == 0 || $index % $itemsPerCol == 0) {
                    $out = static::beginTag('div', ['class' => "col col-" . $colSpan . ""]);
                } else {
                    $out = '';
                }
                $out .= static::radio($name, $checked, ['label' => $label . static::tag('i'), 'labelOptions' => ['class' => 'radio'], 'value' => $value]);
                if ($index == ($itemCount - 1) || ($index + 1) % $itemsPerCol == 0) {
                    $out .= static::endTag('div');
                }
                return $out;
            };
        }
        unset($options['cols'], $options['toggle'], $options['toggleOnText'], $options['toggleOffText'], $options['inline']);

        return parent::radioList($name, $selection, $items, $options);
    }

    /**
     * Add SmartAdmin styling and expand functionality via $options[]
     * - $options['toggle'] bool Set to true to generate toggle switches instead of radio button (Defaults to false)
     * - $options['toggleOnText'] string The text used to signify switch is checked (ON, YES, TRUE, etc.) (Defaults to ON)
     * - $options['toggleOffText'] string The text used to signify switch is NOT checked (OFF, NO, FALSE, etc.) (Defaults to OFF)
     * - $options['inline'] bool Set to true to have radio options appear on same line (Defaults to false)
     * - $options['cols'] int If inline is set to false, radioList will be displayed in 12 col grid (Must be 1,2,3,4,6,12 - Defaults to 1)
     */

    public static function checkboxList($name, $selection = null, $items = [], $options = []) {
        $toggle = isset($options['toggle']) && $options['toggle'] === true ? true : false;
        $inline = isset($options['inline']) && $options['inline'] === true ? true : false;
        if ($toggle) {
            $onText = isset($options['toggleOnText']) && is_string($options['toggleOnText']) ? $options['toggleOnText'] : "ON";
            $offText = isset($options['toggleOffText']) && is_string($options['toggleOffText']) ? $options['toggleOffText'] : "OFF";
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($onText, $offText) {
                return static::checkbox($name, $checked, ['label' => $label . static::tag('i', '',['data-swchoff-text' => $offText, 'data-swchon-text' => $onText]), 'labelOptions' => ['class' => 'toggle'], 'value' => $value]);
            };
        } else if ($inline) {
            static::addCssClass($options, 'inline-group');
            $options['item'] = function ($index, $label, $name, $checked, $value) {
                return static::checkbox($name, $checked, ['label' => $label . static::tag('i'), 'labelOptions' => ['class' => 'checkbox'], 'value' => $value]);
            };
        } else {
            $cols = isset($options['cols']) && 12 % $options['cols'] == 0 ? $options['cols'] : 1;
            $itemCount = count($items);
            $colSpan = 12 / $cols;
            $itemsPerCol = ceil($itemCount / $cols);
            static::addCssClass($options, 'row');
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($colSpan, $itemCount, $itemsPerCol) {
                if ($index == 0 || $index % $itemsPerCol == 0) {
                    $out = static::beginTag('div', ['class' => "col col-" . $colSpan . ""]);
                } else {
                    $out = '';
                }
                $out .= static::checkbox($name, $checked, ['label' => $label . static::tag('i'), 'labelOptions' => ['class' => 'checkbox'], 'value' => $value]);
                if ($index == ($itemCount - 1) || ($index + 1) % $itemsPerCol == 0) {
                    $out .= static::endTag('div');
                }
                return $out;
            };
        }
        unset($options['cols'], $options['toggle'], $options['toggleOnText'], $options['toggleOffText'], $options['inline']);

        return parent::checkboxList($name, $selection, $items, $options);
    }
}