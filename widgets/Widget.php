<?php

/**
 * TODO: Write better docs :)
 */

namespace wma\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

class Widget extends \yii\base\Widget
{
    public $id = null;
    public $title = "Widget";

    protected $_buttons = [];
    protected $_collapsed = false;
    protected $_hidden = false;
    protected $_sortable = false;
    protected $_well = false;
    protected $_icon = null;
    protected $_headerColor = null;
    protected $_toolbars = [];
    protected $_load = null;
    protected $_refresh = 0;

    private $_iconHtml = '';
    private $_validButtons = [
        'toggle',
        'delete',
        'edit',
        'fullscreen',
        'refresh',
        'color',
        'custombutton'
    ];
    private $_validHeaderColors = [
        'magenta',
        'pink',
        'pinkDark',
        'yellow',
        'orange',
        'orangeDark',
        'darken',
        'purple',
        'teal',
        'blueDark',
        'blue',
        'blueLight',
        'red',
        'redLight',
        'white',
        'green',
        'greenDark',
        'greenLight',
    ];
    private $_widgetHtmlOptions = [
        'class' => 'jarviswidget'
    ];

    /**
     * Widget Toolbar (right aligned)
     * Can take a string of HTML for single toolbar or multiple toolbars can be passed as an array
     * @param $toolbars string|array Html to appear on the right side of widget header, each $toolbar will be split
     * by a vertical separator
     */

    public function setToolbars($toolbars) {
        $toolbars = is_string($toolbars) ? [$toolbars] : $toolbars;

        if (is_array($toolbars)) {
            $this->_toolbars = $toolbars;
        }
    }

    /**
     * Default is null, which defers to skin for coloring
     * Valid Colors:
     * 'magenta','pink','pinkDark','yellow','orange','orangeDark','darken','purple','teal','blueDark','blue','blueLight',
     * 'red','redLight','white','green','greenDark','greenLight'
     * @param $color string Color name
     */

    public function setHeaderColor($color) {
        if (is_string($color) && !empty($color) && in_array($color, $this->_validHeaderColors)) {
            $this->_headerColor = $color;
        }
    }

    /**
     * The buttons that will be enabled on this widget.
     * Valid Buttons:
     * 'toggle','delete','edit','fullscreen','refresh','color'
     * @param $buttons array|string List of (string can be used for single button) button names to be enabled
     */

    public function setButtons($buttons) {
        if (is_string($buttons) && !empty($buttons)) {
            $buttons = [$buttons];
        }
        if (is_array($buttons)) {
            foreach ($buttons as $button) {
                if (in_array($button, $this->_validButtons)) {
                    $this->_buttons[] = $button;
                }
            }
        }
    }

    /**
     * Set an icon to appear in header to the left of widget title
     * @param $iconName string Icon name based on font-awesome ... use ONLY icon name without fa-
     *                      GOOD: home
     *                      BAD: fa-home
     */

    public function setIcon($iconName) {
        if (!empty($iconName) && is_string($iconName)) {
            $this->_icon = $iconName;
        }
    }

    /**
     * Will load the specified URL into the widget body. Can be combined with the refresh button and/or the refresh
     * parameter (used to specify an auto reload timer).
     * @param $url string URL of page to load (via ajax request)
     */

    public function setLoad($url) {
        if (!empty($url) && is_string($url)) {
            $this->_load = $url;
        }
    }

    /**
     * Set widget to auto-refresh the URL specified by load parameter (see $this->setLoad($url))
     * @param $seconds int Secondsbetween auto refresh
     */

    public function setRefresh($seconds) {
        if (is_int($seconds) && $seconds >= 1 && $seconds <= 86400) {
            $this->_refresh = $seconds;
        }
    }

    /**
     * Widget can be dragged and dropped
     * @param $sortable bool Allow widget to be draggable (defaults to false)
     */

    public function setSortable($sortable) {
        if (is_bool($sortable)) {
            $this->_sortable = $sortable;
        }
    }

    /**
     * Widget will be hidden on page load when this is true
     * @param $hidden bool Hide widget on page load (defaults to false)
     */

    public function setHidden($hidden) {
        if (is_bool($hidden)) {
            $this->_hidden = $hidden;
        }
    }

    /**
     * Widget will be collapsed on page load when this is true, should usually be accompanied by a toggle button
     * but this is not required.
     * @param $collapsed bool Collapse widget on page load (defaults to false)
     */

    public function setCollapsed($collapsed) {
        if (is_bool($collapsed)) {
            $this->_collapsed = $collapsed;
        }
    }

    /**
     * This will convert the widget to a well (removing header, buttons, etc.)
     * @param $convertWidgetToWell bool Convert widget to well (defaults to false)
     */

    public function setWell($convertWidgetToWell) {
        if (is_bool($convertWidgetToWell)) {
            $this->_well = $convertWidgetToWell;
        }
    }

    public function init() {
        if (empty($this->id)) {
            throw new InvalidConfigException("You must specify a unique id for this widget!");
        } else {
            $this->_widgetHtmlOptions['id'] = $this->id;
        }
        // Icon
        if (!empty($this->_icon)) {
            $this->_iconHtml = Html::tag('span', ' '.Html::tag('i', '', ['class' => "fa fa-".$this->_icon.""]).' ', ['class' => 'widget-icon']);
        }
        // Buttons
        // Set buttons to false that aren't in the $this->_buttons array
        foreach ($this->_validButtons as $button) {
            if (!in_array($button, $this->_buttons)) {
                $this->_widgetHtmlOptions["data-widget-".$button."button"] = 'false';
            }
        }
        // AJAX Load
        if (!empty($this->_load)) {
            $this->_widgetHtmlOptions['data-widget-load'] = $this->_load;
            if ($this->_refresh > 0) {
                $this->_widgetHtmlOptions['data-widget-refresh'] = $this->_refresh;
            }
        }
        // Header Color
        if (!empty($this->_headerColor)) {
            $this->_widgetHtmlOptions['class'] .= ' jarviswidget-color-' . $this->_headerColor;
        }
        // Sortable
        if ($this->_sortable === false) {
            $this->_widgetHtmlOptions['data-widget-sortable'] = 'false';
        }
        // Hidden
        if ($this->_hidden === true) {
            $this->_widgetHtmlOptions['data-widget-hidden'] = 'true';
        }
        // Collapsed
        if ($this->_collapsed === true) {
            $this->_widgetHtmlOptions['data-widget-collapsed'] = 'true';
        }
        // Well
        if ($this->_well === true) {
            $this->_widgetHtmlOptions['class'] .= ' well';
        }

        parent::init();
        ob_start();
    }

    public function run() {
        $content = ob_get_clean();
        return Html::beginTag('div', $this->_widgetHtmlOptions)
                . Html::beginTag('header')
                    . $this->_iconHtml
                    . Html::tag('h2', $this->title . ' ')
                    . $this->getWidgetToolbars()
                . Html::endTag('header')
                . $content
            . Html::endTag('div');
    }

    protected function getWidgetToolbars() {
        if (count($this->_toolbars)) {
            $toolbars = [];
            foreach ($this->_toolbars as $toolbar) {
                $toolbars[] = WidgetHeaderToolbar::widget(['toolbar' => $toolbar]);
            }
            return implode("\n", $toolbars);
        } else {
            return '';
        }
    }

}