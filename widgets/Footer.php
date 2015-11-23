<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use wma\widgets\FooterVersion;
use wma\widgets\FooterCopyright;

class Footer extends \yii\base\Widget
{
    public function run() {
        return Html::beginTag('footer', ['class' => 'main-footer'])
            . FooterVersion::widget()
            . FooterCopyright::widget()
        . Html::endTag('footer');
    }
}