<?php

namespace wma\controllers;

class Controller extends \yii\web\Controller {
    public $layout = '@wma/views/layouts/main';

    public function behaviors() {
        return
            [
                'access' =>
                    [
                        'class' => \yii\filters\AccessControl::className(),
                        'rules' =>
                            [
                                [
                                    'allow' => true,
                                    'roles' => ['admin'],
                                ]
                            ]
                    ]
            ];
    }
}
