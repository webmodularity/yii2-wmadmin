<?php

namespace wma\grid;

class DataColumnStyled extends \wma\grid\DataColumn
{
    public static $colorMap = [];

    public static function getDropdownOptions() {
        $allOptions = [];
        foreach (static::$colorMap as $key => $color) {
            $allOptions[$key] = ['class' => $color];
        }
        return $allOptions;
    }

}