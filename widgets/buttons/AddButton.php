<?php

namespace wma\widgets\buttons;

use yii\helpers\Html;
use yii\helpers\Inflector;
use rmrevin\yii\fontawesome\FA;

class AddButton extends \yii\base\Widget
{
    public $model;
    public $addText = "Add";
    public $itemName;

    public function init() {
        if (empty($this->itemName)) {
            $this->itemName = Inflector::camel2words(Inflector::classify($this->model->tableName()));
        }
    }

    public function run() {
        return Html::submitButton(FA::icon('plus') . '&nbsp;' . $this->addText
            . Html::tag('span', '&nbsp;' . $this->itemName, ['class' => "hidden-xs hidden-sm"]),
            [
                'class' => 'btn btn-primary',
            ]);
    }
}