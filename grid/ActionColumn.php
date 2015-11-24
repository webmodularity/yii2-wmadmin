<?php

namespace wma\grid;

use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use wmc\widgets\bootstrap\DeleteConfirm;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = '{update} {delete}';
    public $contentOptions = [
        'style' => 'white-space: nowrap;width:25px;'
    ];
    public $deleteDisabled;
    public $iconOnly = false;

public function init() {
    if (!isset($this->buttons['delete'])) {
        DeleteConfirm::widget();
        $this->buttons['delete'] = function ($url, $model, $key) {
            $text = $this->iconOnly !== true
                ? ' ' . Html::tag('span', 'Delete', ['class' => 'hidden-xs'])
                : '';
            $options = ['class' => 'btn-danger btn-xs'];
            if (is_callable($this->deleteDisabled) && call_user_func($this->deleteDisabled, $model)) {
                $options['disabled'] = true;
            } else {
                $options['data'] = [
                    'href' => $url,
                    'toggle' => 'delete-confirm',
                    'placement' => 'left'
                ];
            }
            return Button::widget([
                'encodeLabel' => false,
                'label' => FA::icon('trash') . $text,
                'options' => $options
            ]);
        };
    }
    if (!isset($this->buttons['update'])) {
        $this->buttons['update'] = function ($url, $model, $key) {
            $text = $this->iconOnly !== true
                ? ' ' . Html::tag('span', 'Edit', ['class' => 'hidden-xs'])
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
                ? ' ' . Html::tag('span', 'View', ['class' => 'hidden-xs'])
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