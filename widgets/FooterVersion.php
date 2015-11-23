<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class FooterVersion extends \yii\base\Widget
{
    public function run()
    {
        if (!Yii::$app->adminSettings->getOption('template.footer.version')) {
            return '';
        }
        return Html::tag('div', Html::tag('b', Yii::$app->nameCms) . ' v' . Yii::$app->version, ['class' => 'pull-right hidden-xs']);
    }
}