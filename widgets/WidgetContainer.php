<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class WidgetContainer extends \yii\base\Widget
{
    public $htmlOptions = ['class' => "col-xs-12 col-sm-12 col-md-12 col-lg-12"];

    protected $_sortable = true;

    /**
     * TODO: Does not seem to have an effect on sortability - control elements individually for now
     * Widget Container can be dragged and dropped to. No widgets in this container will be sortable/droppable!
     * @param $sortable bool Allow widget container to be draggable (defaults to true)
     */

    public function setSortable($sortable) {
        if ($sortable === false) {
            $this->_sortable = $sortable;
        }
    }

    public function init()
    {
        parent::init();
        if ($this->_sortable === false) {
            $this->htmlOptions['data-widget-grid'] = 'false';
        }
        ob_start();
    }

    public function run() {
        $content = ob_get_clean();
        return Html::tag('article', $content, $this->htmlOptions);
    }
}