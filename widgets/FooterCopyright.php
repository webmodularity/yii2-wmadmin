<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class FooterCopyright extends \yii\base\Widget
{
    protected $_name;
    protected $_link;
    protected $_date;

    private $_html = '';

    public function init() {
        parent::init();
        if (!empty((string)Yii::$app->adminSettings->getOption('template.footer.copyright.name'))) {
            $this->_name = (string)Yii::$app->adminSettings->getOption('template.footer.copyright.name');
            // Link
            if (!empty(Yii::$app->adminSettings->getOption('template.footer.copyright.link'))) {
                $this->_link = Yii::$app->adminSettings->getOption('template.footer.copyright.link');
            }
            // Date
            if (Yii::$app->adminSettings->getOption('template.footer.copyright.date') === true) {
                $this->_date = '&copy;' . date('Y');
            } else if (!empty((string)Yii::$app->adminSettings->getOption('template.footer.copyright.date'))) {
                $this->_date = (string)Yii::$app->adminSettings->getOption('template.footer.copyright.date');
            }
        }

        if ($this->_name) {
            $begin = $this->_date ? $this->_date . ' ' : '';
            $end = $this->_link ? Html::a($this->_name, $this->_link) : $this->_name;
            $this->_html = $begin . $end;
        }
    }

    public function run()
    {
        if (empty($this->_html)) {
            return '';
        }
        return Html::tag('strong', $this->_html);
    }
}