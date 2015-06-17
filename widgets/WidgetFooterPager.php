<?php

namespace wma\widgets;

class WidgetFooterPager extends \yii\widgets\LinkPager
{
    public $hideOnSinglePage = false;
    public $options = [
        'class' => 'pagination pagination-sm no-margin'
    ];
    public $nextPageCssClass = '';
    public $nextPageLabel = "<i class=\"fa fa-angle-right\"></i>";
    public $prevPageCssClass = '';
    public $prevPageLabel = "<i class=\"fa fa-angle-left\"></i>";
}