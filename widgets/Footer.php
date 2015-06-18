<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use wmu\models\UserLog;

class Footer extends \yii\base\Widget
{
    public $companyName = "WebModularity";

    protected $_lastLogin;

    public function init() {
        parent::init();
        $this->_lastLogin = UserLog::find()->where(['app' => UserLog::APP_BACKEND])->lastLogin(Yii::$app->user->id)->one();
    }

    public function run() {
        return Html::beginTag('div', ['class' => 'page-footer'])
        . Html::beginTag('div', ['class' => 'row'])
        . Html::beginTag('div', ['class' => "col-xs-4 col-sm-4"])
        . Html::tag('span', "&copy;" . date('Y') . " " . $this->companyName, ['class' => 'txt-color-white'])
        . Html::endTag('div')
        . Html::beginTag('div', ['class' => "col-xs-8 col-sm-8 text-right"])
        . Html::beginTag('div', ['class' => "txt-color-blueLight inline-block"])
        . Html::tag('em', "Last CMS Login: ", ['class' => "hidden-xs"])
        . Html::tag('i' , '', ['class' => 'fa fa-clock-o txt-color-white']) . '&nbsp;'
        . Yii::$app->formatter->asLocalDateTime($this->_lastLogin->created_at) . ' '
        . Html::tag('i' , '', ['class' => 'fa fa-cloud txt-color-white']) . '&nbsp;'
        . Yii::$app->formatter->asIp($this->_lastLogin->ip)
        . Html::endTag('div')
        . Html::endTag('div')
        . Html::endTag('div')
        . Html::endTag('div');
    }
}