<?php

namespace wma\widgets;

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;
use wmc\widgets\bootstrap\Confirm;

class DeleteButton extends \yii\base\Widget
{
    public $model;
    public $deleteText = "Delete";
    public $itemName;
    public $idField = 'id';
    public $deleteUrl = "delete";
    public $disabled = false;

    public function init() {
        if (empty($this->itemName)) {
            $this->itemName = Inflector::camel2words(Inflector::classify($this->model->tableName()));
        }
        // Load Confirm
        Confirm::widget();
    }

    public function run() {
        $idField = $this->idField;
        return Html::a(FA::icon('times') . '&nbsp;' . $this->deleteText . Html::tag('span', '&nbsp;' . $this->itemName, ['class' => "hidden-xs hidden-sm"]),
            Url::to([$this->deleteUrl, 'id' => $this->model->{$idField}]),
            [
                'class' => 'btn btn-danger',
                'disabled' => $this->disabled,
                'data-toggle' => 'confirmation',
                'data-placement' => 'top'
            ]);
    }
}