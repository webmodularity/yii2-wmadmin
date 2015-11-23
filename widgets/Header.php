<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;

class Header extends \yii\base\Widget
{
    public function init() {
        parent::init();
    }

    public function run() {
        return Html::beginTag('header', ['class' => "main-header"])
                . Logo::widget()
                . Html::beginTag('nav', ['class' => "navbar navbar-static-top", 'role' => "navigation"])
                    . Html::a(Html::tag('span', 'Toggle navigation', ['class' => 'sr-only']), '#', ['class' => 'sidebar-toggle', 'data-toggle' => 'offcanvas', 'role' => 'button'])
                    . Html::beginTag('div', ['class' => 'navbar-custom-menu'])
                        . Html::beginTag('ul', ['class' => 'nav navbar-nav'])
                            . HeaderMessages::widget()
                            . HeaderNotifications::widget()
                            . HeaderTasks::widget()
                            . HeaderUser::widget()
                            . Html::tag('li', Html::a(FA::icon('sign-out'), ['/user/logout'], ['title' => 'SignOut','data' => ['toggle' => 'tooltip', 'placement' => 'bottom']]))
                        . Html::endTag('ul')
                    . Html::endTag('div')
                . Html::endTag('nav')
            . Html::endTag('header');
    }
}