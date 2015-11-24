<?php

namespace wma\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FA;
use wmc\widgets\bootstrap\DeleteConfirm;
use yii\bootstrap\Button;

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
        if (!$this->disabled) {
            // Load Confirm
            DeleteConfirm::widget();
        }
    }

    public function run() {
        $idField = $this->idField;
        $options = ['class' => 'btn btn-danger'];
        if ($this->disabled) {
            $options['disabled'] = true;
        } else {
            $options['data'] = [
                'toggle' => 'delete-confirm',
                'placement' => 'top',
                'href' => Url::to([$this->deleteUrl, 'id' => $this->model->{$idField}])
            ];
        }
        return Button::widget([
            'label' => FA::icon('times') . '&nbsp;' . $this->deleteText . Html::tag('span', '&nbsp;' . $this->itemName, ['class' => "hidden-xs hidden-sm"]),
            'encodeLabel' => false,
            'options' => $options
        ]);
    }
}