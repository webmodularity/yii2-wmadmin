<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class BodyTag extends \yii\base\Widget
{
    private $_options = [
        'class' => 'hold-transition'
    ];

    /**
     * Array of options that will be sent along with auto generated class option.
     * Class option will be appended to auto generated classes.
     * @param $options array ['key' => 'value'] options to be passed to body tag
     */

    public function setOptions($options) {
        if (is_array($options)) {
            Html::addCssClass($options, $this->_options['class']);
            $this->_options = ArrayHelper::merge($options, $this->_options);
        }
    }

    public function init()
    {
        parent::init();
        $classes = [];
        // Skin
        if (!empty(Yii::$app->adminSettings->getOption('template.skin'))) {
            $classes[] = 'skin-' . Yii::$app->adminSettings->getOption('template.skin');
        }
        // Nav
        if (Yii::$app->adminSettings->getOption('template.header.nav')) {
            $classes[] = 'layout-top-nav';
        } else if (Yii::$app->adminSettings->getOption('template.sidebar.collapsed')) {
            $classes[] = 'sidebar-collapse';
        }

        // Sidebar Mini
        if (Yii::$app->adminSettings->getOption('template.sidebar.mini')) {
            $classes[] = 'sidebar-mini';
        }

        // Fixed/Boxed
        if (Yii::$app->adminSettings->getOption('template.layout.boxed')) {
            $classes[] = 'layout-boxed';
        } else if (Yii::$app->adminSettings->getOption('template.layout.fixed')) {
            $classes[] = 'fixed';
        }
        Html::addCssClass($this->_options, $classes);
    }

    public function run()
    {
        return Html::beginTag('body', $this->_options);
    }
}