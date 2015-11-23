<?php

namespace yii\helpers;

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
}