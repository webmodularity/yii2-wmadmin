<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class DetailView extends \yii\widgets\DetailView
{
    public $bordered = true;
    public $striped = true;
    public $hover = false;
    public $responsive = false;

    /**
     * @var bool Set to true to force long strings to wrap (without whitespace)
     */
    public $wrapLong = false;

    public $options = ['class' => 'table detail-view'];

    public function init() {
        parent::init();
        if ($this->bordered) {
            Html::addCssClass($this->options, 'table-bordered');
        }
        if ($this->striped) {
            Html::addCssClass($this->options, 'table-striped');
        }
        if ($this->hover) {
            Html::addCssClass($this->options, 'table-hover');
        }
        if ($this->responsive) {
            Html::addCssClass($this->options, 'table-responsive');
        }
        if ($this->wrapLong) {
            Html::addCssClass($this->options, 'wrap-long');
        }
    }
}