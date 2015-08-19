<?php

namespace wma\controllers;

class SiteController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'file' => [
                'class' => 'wmc\web\FileAction'
            ],
            'page' => [
                'class' => 'wmf\web\PageAction',
                'viewFile' => '@frontend/views/site/page'
            ]
        ];
    }
}