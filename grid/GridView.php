<?php

namespace wma\grid;

use yii\helpers\Html;

class GridView extends \yii\grid\GridView
{
    public $options = [
        'class' => 'table-responsive'
    ];
    public $dataColumnClass = 'wma\grid\DataColumn';
    public $filterPosition = self::FILTER_POS_BODY;
    public $filterErrorOptions = [
        'tag' => 'em',
        'class' => 'invalid'
    ];
    public $summaryOptions = [
        'class' => 'pull-left no-margin',
        'tag' => 'p',
    ];
    public $tableOptions = [
        'class' => 'table table-striped table-bordered smart-form'
    ];
    public $layout = "{items}\n<div class='widget-footer'>{summary}\n{pager}</div>";
    public $pager = [
        'class' => 'wma\widgets\WidgetFooterPager'
    ];
    public $emptyText = '<a class="btn btn-primary btn-sm disabled pull-left">No Results Found.</a>';

    public function renderSummary() {
        $summary = parent::renderSummary();
        if (!empty($summary)) {
            return Html::a($summary, null, ['class' => "btn btn-primary btn-sm disabled pull-left"]);
        }
        return '';
    }
}