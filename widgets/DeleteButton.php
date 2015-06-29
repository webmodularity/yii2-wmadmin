<?php

namespace wma\widgets;

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;

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
    }

    public function run() {
        $idField = $this->idField;
        return Html::a(FA::icon('times') . '&nbsp;' . $this->deleteText
            . Html::tag('span', '&nbsp;' . $this->itemName, ['class' => "hidden-xs hidden-sm"]), null,
            [
                'class' => 'btn btn-danger',
                'disabled' => $this->disabled,
                'data-wma-delete-url' => Url::to([$this->deleteUrl, 'id' => $this->model->{$idField}]),
                'data-wma-delete-item-name' => $this->itemName
            ]);
    }
}