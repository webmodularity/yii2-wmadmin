<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class ContentContainer extends \yii\base\Widget
{
    public $htmlOptions = ['id' => "content"];

    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run() {
        $content = ob_get_clean();
        return Html::tag('div', $content, $this->htmlOptions);
    }
}