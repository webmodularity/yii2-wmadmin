<?php

namespace wma\grid;

use Yii;
use yii\bootstrap\Button;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Inflector;

class ActionUserAdminColumn extends \wma\grid\ActionColumn
{

    public function init() {
        if (!isset($this->buttons['delete'])) {
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
                        'data-wma-delete-item-name' => $deleteItemName,
                        'disabled' => Yii::$app->user->id == $model->id
                    ],
                    'tagName' => 'a'
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
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
        }

        parent::init();
    }

}