<?php

namespace wma\widgets\input\file;

class FileInput extends \wmc\widgets\bootstrap\input\file\FileInput
{
    public function init() {
        $this->setIconSet('fa');

        parent::init();
    }
}