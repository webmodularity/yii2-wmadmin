<?php

/** TODO: Finish Dropdown Body Section (by designing something meaningful to go in body) */

namespace wma\widgets;

use rmrevin\yii\fontawesome\FA;
use Yii;
use yii\helpers\Html;
use wma\widgets\UserIcon;
use wmc\models\user\UserLog;

class HeaderUser extends \yii\base\Widget
{
    protected $_logins = [];

    public function init() {
        parent::init();
        $this->_logins = UserLog::find()->lastLogin(Yii::$app->user->id)->backend()->limit(3)->all();
    }

    public function run()
    {
        if (!Yii::$app->adminSettings->getOption('template.header.user')) {
            return '';
        }
        return Html::beginTag('li', ['class' => 'dropdown user user-menu'])
            . Html::a(UserIcon::widget(['size' => 160, 'htmlOptions' => ['class' => 'user-image']])
                . Html::tag('span', Yii::$app->user->identity->person->fullName, ['class' => 'hidden-xs']), '#',
                ['class' => 'dropdown-toggle', 'data' => ['toggle' => "dropdown"]])
            // User Dropdown
                . Html::beginTag('ul', ['class' => 'dropdown-menu'])
                    // Header
                    . Html::tag('li',
                        UserIcon::widget(['size' => 160, 'htmlOptions' => ['class' => 'img-circle']]) .
                        Html::tag('p', Yii::$app->user->identity->person->fullName . ' - ' . Yii::$app->user->identity->group->name) .
                        Html::tag('small', 'Member since ' . date('M. Y', strtotime(Yii::$app->user->identity->created_at))),
                    ['class' => 'user-header'])
                    // Body
                    . Html::tag('li', $this->lastLoginTable())
                    // Footer
                    . Html::tag('li',
                        Html::tag('div', Html::a('Profile', ['/user-admin/update', 'id' => Yii::$app->user->id], ['class' => 'btn btn-default btn-flat']), ['class' => 'pull-left']) .
                        Html::tag('div', Html::a('Sign Out', '/user/logout', ['class' => 'btn btn-default btn-flat']), ['class' => 'pull-right']),
                    ['class' => 'user-footer'])
                . Html::endTag('ul')
            . Html::endTag('li');
    }

    protected function lastLoginTable() {
        $rows = [];
        foreach ($this->_logins as $login) {
            $rows[] = Html::beginTag('tr')
                . Html::tag('td', Yii::$app->formatter->asLocalDateTime($login->created_at, 'm/d/Y h:i:s A'))
                . Html::tag('td', Yii::$app->formatter->asIp($login->ip))
                . Html::endTag('tr');
        }
        return Html::beginTag('table', ['class' => 'table'])
            . Html::beginTag('tbody')
                . Html::beginTag('tr')
                    . Html::tag('th', 'Recent Logins')
                    . Html::tag('th', 'IP')
                . Html::endTag('tr')
                . implode('', $rows)
            . Html::endTag('tbody')
        . Html::endTag('table');
    }
}