<?php

namespace wma\widgets;

class LinkPager extends \yii\widgets\LinkPager
{
    public $hideOnSinglePage = false;
    public $options = [
        'class' => 'pagination pagination-sm no-margin pull-right'
    ];
    public $nextPageCssClass = '';
    public $nextPageLabel = "<i class=\"fa fa-angle-right\"></i>";
    public $prevPageCssClass = '';
    public $prevPageLabel = "<i class=\"fa fa-angle-left\"></i>";
}