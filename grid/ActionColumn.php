<?php

namespace wma\grid;

use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Inflector;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = '{update} {delete}';
    public $contentOptions = [
        'style' => 'white-space: nowrap;width:30px;'
    ];
    public $deleteItemName;

public function init() {
    $this->buttons['delete'] = function ($url, $model, $key) {
        $deleteItemName = empty($this->deleteItemName)
            ? Inflector::camel2words(Inflector::classify($model->tableName()))
            : $this->deleteItemName;
        return Button::widget([
            'encodeLabel' => false,
            'label' => FA::icon('trash') . ' ' . Html::tag('span', 'Delete', ['class' => 'hidden-xs hidden-sm']),
            'options' => [
                'class' => 'btn-danger btn-xs',
                'data-wma-delete-url' => $url,
                'data-wma-delete-item-name' => $deleteItemName
            ],
            'tagName' => 'a'
        ]);
    };
    $this->buttons['update'] = function ($url, $model, $key) {
        return Button::widget([
            'encodeLabel' => false,
            'label' => FA::icon('edit') . ' ' . Html::tag('span', 'Edit', ['class' => 'hidden-xs hidden-sm']),
            'options' => [
                'class' => 'btn-info btn-xs',
                'href' => $url
            ],
            'tagName' => 'a'
        ]);
    };
    $this->buttons['view'] = function ($url, $model, $key) {
        return Button::widget([
            'encodeLabel' => false,
            'label' => FA::icon('eye') . ' ' . Html::tag('span', 'View', ['class' => 'hidden-xs hidden-sm']),
            'options' => [
                'class' => 'btn-info btn-xs',
                'href' => $url
            ],
            'tagName' => 'a'
        ]);
    };
    parent::init();
}

}