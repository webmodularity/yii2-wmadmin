<?php

namespace wma\grid;

use yii\helpers\Html;

class GridView extends \yii\grid\GridView
{
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
        'class' => 'table table-striped table-bordered table-hover'
    ];
    public $pager = [
        'class' => 'wma\widgets\LinkPager'
    ];
    public $emptyText = '<a class="btn btn-primary btn-sm disabled pull-left">No Results Found.</a>';
    public $layout = "{items}\n<div class='box-footer'>{summary}\n{pager}</div>";

    public function renderSummary() {
        $summary = parent::renderSummary();
        if (!empty($summary)) {
            return Html::a($summary, null, ['class' => "btn btn-primary btn-sm disabled pull-left"]);
        }
        return '';
    }
}