<?php

namespace wma\widgets;

use Yii;
use wmc\helpers\Html;
use rmrevin\yii\fontawesome\FA;

class LoggedInUser extends \yii\base\Widget
{
    private $_displayName;

    public function setDisplayName($type) {
        $validNames = [
            'username' => Yii::$app->user->identity->username,
            'name' => Yii::$app->user->identity->person->first_name,
            'full_name' => Yii::$app->user->identity->person->fullName,
            'email' => Yii::$app->user->identity->email
        ];
            $this->_displayName = $validNames[$type];
    }

    public function init() {
        if (!$this->_displayName) {
            $this->_displayName = 'username';
        }
        parent::init();
    }

    public function run() {
        return Html::tag('div',
            Html::tag(
                'span',
                Html::a(
                    Html::img(
                        UserIcon::widget(),
                        ['class' => 'online']
                    )
                    . Html::tag(
                        'span',
                        $this->_displayName
                    )
                    . '&nbsp;'
                    . FA::icon('angle-down'),
                    "javascript:void(0);",
                    [
                        'id' => 'show-shortcut',
                        'data-action' => 'toggleShortcut'
                    ]
                )
            )
        , ['class' => 'login-info']);
    }
}