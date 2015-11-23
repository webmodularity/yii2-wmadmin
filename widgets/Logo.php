<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class Logo extends \yii\base\Widget
{
    /**
     * @var string|array Will be passed to Url::to() to generate link for logo
     * Defaults to Url::home()
     */
    public $url;
    /**
     * @var bool Set to false if mini version is not needed (for example login page)
     */
    public $useMini = true;

    public function init() {
        $this->url = empty($this->url) ? Url::home() : Url::to($this->url);
    }

    public function run() {
        if ($this->useMini) {
            return Html::a(Html::tag('span', Yii::$app->nameShort, ['class' => 'logo-mini'])
                . Html::tag('span', $this->getFullName(), ['class' => 'logo-lg']),
                $this->url, ['class' => 'logo']);
        } else {
            return Html::tag('div', Html::a($this->getFullName(), $this->url,  ['class' => 'logo']), ['class' => "login-logo"]);
        }
    }

    public function getFullName() {
        return Html::tag('b', Yii::$app->name) . Yii::$app->nameCms;
    }
}