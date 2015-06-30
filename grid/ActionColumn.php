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
        'style' => 'white-space: nowrap;width:25px;'
    ];
    public $deleteItemName;
    public $iconOnly = false;

public function init() {
    if (!isset($this->buttons['delete'])) {
        $this->buttons['delete'] = function ($url, $model, $key) {
            $deleteItemName = empty($this->deleteItemName)
                ? Inflector::camel2words(Inflector::classify($model->tableName()))
                : $this->deleteItemName;
            $text = $this->iconOnly !== true
                ? ' ' . Html::tag('span', 'Delete', ['class' => 'hidden-xs hidden-sm'])
                : '';
            return Button::widget([
                'encodeLabel' => false,
                'label' => FA::icon('trash' . $text),
                'options' => [
                    'class' => 'btn-danger btn-xs',
                    'data-wma-delete-url' => $url,
                    'data-wma-delete-item-name' => $deleteItemName
                ],
                'tagName' => 'a'
            ]);
        };
    }
    if (!isset($this->buttons['update'])) {
        $this->buttons['update'] = function ($url, $model, $key) {
            $text = $this->iconOnly !== true
                ? ' ' . Html::tag('span', 'Edit', ['class' => 'hidden-xs hidden-sm'])
                : '';
            return Button::widget([
                'encodeLabel' => false,
                'label' => FA::icon('edit') . $text,
                'options' => [
                    'class' => 'btn-info btn-xs',
                    'href' => $url
                ],
                'tagName' => 'a'
            ]);
        };
    }
    if (!isset($this->buttons['view'])) {
        $this->buttons['view'] = function ($url, $model, $key) {
            $text = $this->iconOnly !== true
                ? ' ' . Html::tag('span', 'View', ['class' => 'hidden-xs hidden-sm'])
                : '';
            return Button::widget([
                'encodeLabel' => false,
                'label' => FA::icon('eye') . $text,
                'options' => [
                    'class' => 'btn-info btn-xs',
                    'href' => $url
                ],
                'tagName' => 'a'
            ]);
        };
    }
    parent::init();
}

}