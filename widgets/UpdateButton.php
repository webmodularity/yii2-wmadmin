<?php

namespace wma\widgets;

use yii\helpers\Html;
use yii\helpers\Inflector;
use rmrevin\yii\fontawesome\FA;

class UpdateButton extends \yii\base\Widget
{
    public $model;
    public $updateText = "Update";
    public $itemName;

    public function init() {
        if (empty($this->itemName)) {
            $this->itemName = Inflector::camel2words(Inflector::classify($this->model->tableName()));
        }
    }

    public function run() {
        return Html::submitButton(FA::icon('edit') . '&nbsp;' . $this->updateText
            . Html::tag('span', '&nbsp;' . $this->itemName, ['class' => "hidden-xs hidden-sm"]),
            [
                'class' => 'btn btn-primary',
            ]);
    }
}