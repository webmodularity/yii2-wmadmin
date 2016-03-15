<?php

namespace wma\grid\data;

use Yii;
use wmc\models\FileType;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;

class FileTypeColumn extends \wma\grid\DataColumnIcon
{
    public $format = 'raw';

    public $filterAllowIds = [];
    public $filterDenyIds = [];

    public function init() {
        $this->filter = FileType::getFileTypeList();
        $this->value = function ($model, $key, $index, $column) {
            return FA::icon($model->fileType->iconName, ['class' => 'text-center']) . '&nbsp;' . $model->fileType->name;
        };
    }

}