<?php

namespace wma\widgets;

use rmrevin\yii\fontawesome\FA;
use Yii;
use yii\helpers\Html;
use wma\widgets\UserIcon;

class SidebarUser extends \yii\base\Widget
{
    public function run()
    {
        if (!Yii::$app->adminSettings->getOption('template.sidebar.user')) {
            return '';
        }
        return Html::beginTag('div', ['class' => 'user-panel'])
                . Html::tag('div', UserIcon::widget(['size' => 160, 'htmlOptions' => ['class' => 'img-circle']]), ['class' => 'pull-left image'])
                . Html::tag('div',
                    Html::tag('p', Yii::$app->user->identity->person->fullName) .
                    Html::a(FA::icon('circle', ['class' => 'text-success']) . ' Online', '#'),
                ['class' => 'pull-left info'])
            . Html::endTag('div');
    }
}