<?php

namespace wma\controllers;

use yii\filters\VerbFilter;
use \yii\filters\AccessControl;

class Controller extends \yii\web\Controller {
    public $layout = '@wma/views/layouts/main';

    public function behaviors() {
        return
            [
                'access' =>
                    [
                        'class' => AccessControl::className(),
                        'rules' =>
                            [
                                [
                                    'allow' => true,
                                    'roles' => ['admin'],
                                ]
                            ]
                    ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['post'],
                    ],
                ]
            ];
    }
}
