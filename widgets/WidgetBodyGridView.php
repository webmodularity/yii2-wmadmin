<?php

namespace wma\widgets;

use yii\helpers\Html;

class WidgetBodyGridView extends \yii\grid\GridView
{
    public $bodyOptions = [];

    public $options = [
        'role' => 'content'
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
        'class' => 'table table-striped table-bordered table-hover smart-form'
    ];
    public $pager = [
        'class' => 'wma\widgets\WidgetFooterPager'
    ];
    public $emptyText = '<a class="btn btn-primary btn-sm disabled pull-left">No Results Found.</a>';

    public function init() {
        $this->layout = WidgetBody::widget(array_merge(
            $this->bodyOptions,
            [
                'content' => "<div class='widget-body-toolbar'><div class='row'><div class='col-xs-4'>{summary}\n</div></div></div>
                                <div class='table-responsive no-margin'>{items}</div>\n<div class='widget-footer'>{pager}</div>",
                'wrap' => false]
        ));
        parent::init();
    }

    public function renderSummary() {
        $summary = parent::renderSummary();
        if (!empty($summary)) {
            return Html::a($summary, null, ['class' => "btn btn-primary btn-sm disabled pull-left"]);
        }
        return '';
    }
}