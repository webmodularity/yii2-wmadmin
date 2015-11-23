<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use wma\widgets\Breadcrumbs;

class ContentHeader extends \yii\base\Widget
{
    protected $_subTitle;
    protected $_links = [];

    public function init() {
        parent::init();
        $this->_subTitle = empty($this->view->params['subTitle']) ? '' : Html::tag('small', $this->view->params['subTitle']);
        // Check for standard $this->view->param['breadcrumb']
        if (isset($this->view->params['breadcrumbs']) && !empty($this->view->params['breadcrumbs'])) {
            $this->_links = $this->view->params['breadcrumbs'];
        }
    }

    public function run() {
        return Html::beginTag('section', ['class' => 'content-header'])
            . Html::tag('h1', $this->view->title . $this->_subTitle)
            . Breadcrumbs::widget(['tag' => 'ol', 'links' => $this->_links])
        . Html::endTag('section');
    }
}