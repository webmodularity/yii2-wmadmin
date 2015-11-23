<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use wma\widgets\SidebarUser;
use wma\widgets\SidebarSearch;
use wma\widgets\SidebarMenu;

class Sidebar extends \yii\base\Widget
{
    public function init()
    {
        parent::init();
    }

    public function run() {
        return Html::beginTag('aside', ['class' => 'main-sidebar'])
                . Html::beginTag('section', ['class' => 'sidebar'])
                    . SidebarUser::widget()
                    . SidebarSearch::widget()
                    . SidebarMenu::widget()
                . Html::endTag('section')
            . Html::endTag('aside');
    }
}