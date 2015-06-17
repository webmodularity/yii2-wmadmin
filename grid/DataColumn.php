<?php

namespace wma\grid;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;
use yii\helpers\Inflector;
use yii\helpers\Html;

class DataColumn extends \yii\grid\DataColumn
{
    public $filterContainerOptions = [
        'class' => 'no-margin'
    ];

    /**
     * @inheritdoc
     */
    protected function renderHeaderCellContent()
    {
        if ($this->header !== null || $this->label === null && $this->attribute === null) {
            return parent::renderHeaderCellContent();
        }
        $provider = $this->grid->dataProvider;
        if ($this->label === null) {
            if ($provider instanceof ActiveDataProvider && $provider->query instanceof ActiveQueryInterface) {
                /* @var $model Model */
                $model = new $provider->query->modelClass;
                $label = $model->getAttributeLabel($this->attribute);
            } else {
                $models = $provider->getModels();
                if (($model = reset($models)) instanceof Model) {
                    /* @var $model Model */
                    $label = $model->getAttributeLabel($this->attribute);
                } else {
                    $label = Inflector::camel2words($this->attribute);
                }
            }
        } else {
            $label = $this->label;
        }
        if ($this->attribute !== null && $this->enableSorting &&
            ($sort = $provider->getSort()) !== false && $sort->hasAttribute($this->attribute)) {
            $encodedLabel = $this->encodeLabel ? Html::encode($label) : $label;
            $icon = $sort->getAttributeOrder($this->attribute) == SORT_DESC ? "fa fa-sort-alpha-desc" : "fa fa-sort-alpha-asc";
            return $encodedLabel . $sort->link($this->attribute, array_merge($this->sortLinkOptions, ['class' => 'btn btn-xs btn-default pull-right','label' => Html::tag('i', '', ['class' => $icon])]));
        } else {
            return $this->encodeLabel ? Html::encode($label) : $label;
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            return $this->filter;
        }
        $model = $this->grid->filterModel;
        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            if ($model->hasErrors($this->attribute)) {
                Html::addCssClass($this->filterContainerOptions, 'state-error');
                $error = ' ' . Html::error($model, $this->attribute, $this->grid->filterErrorOptions);
            } else {
                $error = '';
            }
            if (is_array($this->filter)) {
                // TODO: Convert this to a Select2 widget?
                $options = array_merge(['prompt' => ''], $this->filterInputOptions);
                return Html::activeDropDownList($model, $this->attribute, $this->filter, $options) . $error;
            } else {
                return Html::beginTag('section', $this->filterContainerOptions)
                . Html::beginTag('label', ['class' => 'input'])
                . Html::tag('i', '', ['class' => 'icon-append fa fa-search'])
                . Html::activeTextInput($model, $this->attribute, array_merge($this->filterInputOptions))
                . Html::endTag('label')
                . $error
                . Html::endTag('section');
            }
        } else {
            return parent::renderFilterCellContent();
        }
    }

}