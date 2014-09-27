<?php

namespace wma\controllers;

use Yii;
use wma\controllers\Controller;
use wma\models\LoginForm;
use wma\models\User;
use wma\models\Person;

class UserController extends Controller
{
    public $layout = 'views/layouts/login';


    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                    'model' => $model,
                ]);
        }
    }

    public function actionRegister() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = new User();
        $person = new Person();

        if ($user->load(Yii::$app->request->post('User')) && $person->load(Yii::$app->request->post('Person'))) {
          /**  $addressLocation = $model->addressLocation->findOneFromAttributes();
            if (is_null($addressLocation)) {
                if ($model->addressLocation->save()) {
                    $model->link('addressLocation', $model->addressLocation);
                }
            } else {
                $model->populateRelation('addressLocation', $addressLocation);
                $model->link('addressLocation', $model->addressLocation);
            }
            if (!is_null($model->addressLocation) && $model->save()) {
                $addressLocationId = $model->addressLocation->id;
            }
            if (!is_null($addressLocationId)) {
                $model->address_location_id = $addressLocationId;
                $addressId = $model->PkFromAttributes;
                if (is_null($addressId) && $model->save()) {
                    $addressId = $model->id;
                }

                if (!is_null($addressId)) {
                    return $this->redirect(['view', 'id' => $addressId]);
                }
            } */

        }

        return $this->render('register', [
                'user' => $user,
                'person' => $person
            ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
