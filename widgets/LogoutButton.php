<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;

class LogoutButton extends \yii\base\Widget
{
    public function run() {
        return Html::tag(
            'span',
            Html::a(
                FA::icon('sign-out'),
                ['/user/logout'],
                [
                    'title' => 'Sign Out',
                    'data-action' => 'userLogout',
                    'data-logout-msg' => 'Are you sure you want to log out?'
                ]
            )
        );
    }
}