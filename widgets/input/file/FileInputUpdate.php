<?php

namespace wma\widgets\input\file;

use yii\helpers\Html;

class FileInputUpdate extends FileInput
{
    public function init() {
        parent::init();
        
        if (!isset($this->_pluginOptions['initialCaption'])) {
            $this->_pluginOptions['initialCaption'] = $this->model->getUploadedFileName($this->attribute);
        }

        $this->_pluginOptions['overwriteInitial'] = true;
        if ($this->model->getUploadedFileModel($this->attribute)->file_type_category_name == 'image') {
            $this->_pluginOptions['initialPreview'] = Html::img($this->model->getUploadedFileModel($this->attribute)->url, ['class' => 'file-preview-image']);
        } else {
            // All other file types
            $this->_pluginOptions['initialPreview'] = Html::beginTag('div', ['class' => 'file-preview-other'])
                . $this->getPreviewIcon()
                . Html::endTag('div');
        }

        $this->disabled = true;
    }
}