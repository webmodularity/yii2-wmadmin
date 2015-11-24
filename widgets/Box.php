<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class Box extends \yii\base\Widget
{
    static $validStyles = ['default', 'primary', 'info', 'warning', 'success', 'danger'];
    static $toolMap = [
        'collapse' => '<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>',
        'remove' => '<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>'
    ];

    public $options = [];
    public $bodyOptions = [];
    public $title = 'Title';
    public $solid = false;
    public $padding = true;
    public $responsive = true;
    public $headerBorder = true;
    public $footer;
    public $disabled = false;

    protected $_style;
    protected $_tools = [];

    public function setStyle($style) {
        if (in_array($style, static::$validStyles)) {
            $this->_style = $style;
        }
    }

    public function getStyle() {
        return $this->_style;
    }

    public function setTools($tools) {
        if (is_array($tools) && !empty($tools)) {
            foreach ($tools as $tool) {
                if (in_array($tool, array_keys(static::$toolMap))) {
                    $this->_tools[] = static::$toolMap[$tool];
                } else {
                    $this->_tools[] = $tool;
                }
            }
        }
    }

    public function getTools() {
        return $this->_tools;
    }

    public function init()
    {
        parent::init();

        // Container Options
        $addClass = ['box'];
        if ($this->solid) {
            $addClass[] = 'box-solid';
        }
        if (!is_null($this->_style)) {
            $addClass[] = 'box-' . $this->_style;
        }
        Html::addCssClass($this->options, $addClass);

        // Body Options
        Html::addCssClass($this->bodyOptions, 'box-body');
        if (!$this->padding) {
            Html::addCssClass($this->bodyOptions, 'no-padding');
        }
        if ($this->responsive) {
            Html::addCssClass($this->bodyOptions, 'table-responsive');
        }

        if (!$this->disabled) {
            ob_start();
        }
    }

    public function run() {
        if ($this->disabled) {
            return '';
        }
        $content = ob_get_clean();
        return Html::beginTag('div', $this->options)
                . $this->renderHeader()
                . Html::tag('div', $content, $this->bodyOptions)
                . $this->renderFooter()
            . Html::endTag('div');
    }

    protected function renderHeader() {
        $headerOptions = ['class' => 'box-header'];
        // Header Bottom Border
        if ($this->headerBorder) {
            Html::addCssClass($headerOptions, 'with-border');
        }
        // Tools
        $tools = !empty($this->tools) ? Html::tag('div', implode("\n", $this->tools), ['class' => 'box-tools pull-right']) : '';

        return Html::beginTag('div', $headerOptions)
                . Html::tag('h3', $this->title, ['class' => 'box-title'])
                . $tools
            . Html::endTag('div');
    }

    protected function renderFooter() {
        if (empty($this->footer)) {
            return '';
        }
        $footerOptions = ['class' => 'box-footer'];
        $footerContent = is_array($this->footer) ? Html::tag('div', implode("\n", $this->footer), ['class' => 'pull-right']) : $this->footer;
        return Html::tag('div', $footerContent, $footerOptions);
    }
}