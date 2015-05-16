<?php

/**
 * TODO: Add buttons (shortcut only if not always visible) on right side of ribbon based on:
 * <!-- You can also add more buttons to the
 * ribbon for further usability
 * Example below:
 * <span class="ribbon-button-alignment pull-right">
 * <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
 * <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
 * <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
 * </span> -->
 */

namespace wma\widgets;

use Yii;
use wmc\helpers\Html;
use yii\widgets\Breadcrumbs;
use rmrevin\yii\fontawesome\FA;

class Ribbon extends \yii\base\Widget
{
    protected $_links = [];

    /**
     * @param $links Array of links as defined in yii\widgets\Breadcrumbs::$links property
     */

    public function setLinks($links) {
        if (is_array($links)) {
            $this->_links = $links;
        }
    }

    public function init() {
        parent::init();
        if (empty($this->_links)) {
            // Check for standard $this->view->param['breadcrumb']
            if (isset($this->view->params['breadcrumbs']) && !empty($this->view->params['breadcrumbs'])) {
                $this->_links = $this->view->params['breadcrumbs'];
            }
        }
    }

    public function run() {
        return Html::beginTag('div', ['id' => 'ribbon'])
            // Refresh LocalStorage button
            . Html::beginTag('span', ['class' => 'ribbon-button-alignment'])
                . Html::beginTag('span',
                    [
                        'id' => 'refresh',
                        'rel' => 'tooltip',
                        'class' => 'btn btn-ribbon',
                        'data-action' => 'resetWidgets',
                        'data-title' => 'refresh',
                        'data-placement' => 'bottom',
                        'data-original-title' => "<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings.",
                        'data-html' => 'true'
                    ])
                    . ' ' . FA::Icon('refresh')
                . Html::endTag('span')
            . Html::endTag('span')
            // Breadcrumbs
            . Breadcrumbs::widget(['tag' => 'ol', 'links' => $this->_links])
            . Html::endTag('div');
    }
}