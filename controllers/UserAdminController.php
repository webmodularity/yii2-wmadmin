<?php

namespace wma\controllers;

use wmc\models\user\UserKey;
use Yii;
use wmc\models\user\User;
use wmc\models\user\UserSearch;
use wmc\models\user\UserLog;
use wmc\models\user\UserLogSearch;
use wmc\models\user\UserKeySearch;
use wma\widgets\Alert;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UserAdminController implements the CRUD actions for User model.
 */
class UserAdminController extends Controller
{
    protected $_views = [
        'index' => '@wma/views/user-admin/index',
        'update' => '@wma/views/user-admin/update',
        'viewUserLog' => '@wma/views/user-admin/view'
    ];

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
                                    'actions' => ['user-key-delete', 'user-key-create'],
                                    'roles' => ['su']
                                ],
                                [
                                    'allow' => false,
                                    'actions' => ['user-key-delete', 'user-key-create']
                                ],
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

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render($this->_views['index'], [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException On permission violation
     */
    public function actionViewUserLog($id)
    {
        $model = $this->findUserLogModel($id);

        if ($model->user->group_id > Yii::$app->user->identity->group_id) {
            UserLog::add(UserLog::ACTION_ACCESS, UserLog::RESULT_FAIL, null, "User attempting to ACCESS UserLog record without proper UserGroup access. User ID: (".$model->user->id.")");
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render($this->_views['viewUserLog'], [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be refresh()ed
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If group ID of current user is lower than that of user being edited
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $logSearchModel = new UserLogSearch(['user_id' => $model->id]);
        $logDataProvider = $logSearchModel->search(Yii::$app->request->queryParams);

        $keySearchModel = new UserKeySearch();
        $keyDataProvider = $keySearchModel->search(['UserKeySearch' => ['user_id' => $model->id]]);

        if ($model->group_id > Yii::$app->user->identity->group_id) {
            Yii::error("User attempting to UPDATE user record without proper UserGroup access. User ID: (".$model->id.")");
            UserLog::add(UserLog::ACTION_ACCESS, UserLog::RESULT_FAIL, null, "User attempting to UPDATE user record without proper UserGroup access. User ID: (".$model->id.")");
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "User Updated!",
                    'message' => "Successfully updated record for ".$model->email."",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        } else {
            if (Yii::$app->request->isPost) {
                Yii::$app->alertManager->add(Alert::widget(
                    [
                        'heading' => "User Updated Failed!",
                        'message' => "Failed to update user!",
                        'style' => 'danger',
                        'icon' => 'times-circle-o'
                    ]));
            }
            return $this->render($this->_views['update'], [
                'model' => $model,
                'logSearchModel' => $logSearchModel,
                'logDataProvider' => $logDataProvider,
                'keyDataProvider' => $keyDataProvider
            ]);
        }
    }

    /**
     * Sets status to USER::STATUS_DELETED
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException If group ID of current user is lower than that of user being edited
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->group_id > Yii::$app->user->identity->group_id) {
            UserLog::add(UserLog::ACTION_ACCESS, UserLog::RESULT_FAIL, null, "User attempting to DELETE user record without proper UserGroup access. User ID: (".$model->id.")");
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->status != User::STATUS_DELETED) {
            $model->status = User::STATUS_DELETED;
            if ($model->save()) {
                Yii::$app->alertManager->add(Alert::widget(
                    [
                        'heading' => "User Deleted!",
                        'message' => "The User has been deleted. This record can be recovered by filtering user status to 'Deleted'.",
                        'style' => 'success',
                        'icon' => 'check-square-o'
                    ]));
            } else {
                Yii::$app->alertManager->add(Alert::widget(
                    [
                        'heading' => 'Delete User Failed!',
                        'message' => "The User could not be deleted, the server encountered an error.",
                        'style' => 'danger',
                        'icon' => 'times-circle-o'
                    ]));
            }
        } else {
            $deletedUser = $model->getAttributes();
            $deletedPerson = $model->person->getAttributes();
            if ($model->delete()) {
                // Dump info to Yii Log
                Yii::warning("User Deleted: (ID: ".$model->id.") (".$model->email.")\n\n
                User: ".\yii\helpers\VarDumper::dumpAsString($deletedUser)."\n\n
                Person: ".\yii\helpers\VarDumper::dumpAsString($deletedPerson)."", 'user.delete');
                Yii::$app->alertManager->add(Alert::widget(
                    [
                        'heading' => 'User PERMANENTLY Deleted!',
                        'message' => "The User has been PERMANENTLY deleted. Record removed from database, no future recovery available.",
                        'style' => 'success',
                        'icon' => 'check-square-o'
                    ]));
            } else {
                Yii::$app->alertManager->add(Alert::widget(
                    [
                        'heading' => 'Delete User Failed!',
                        'message' => "The User could not be PERMANENTLY deleted, the server encountered an error:",
                        'style' => 'danger',
                        'icon' => 'times-circle-o'
                    ]));
            }
        }
        return $this->redirect(['index']);
    }

    public function actionUserKeyDelete($id, $user_id) {
        $userKey = $this->findUserKeyModel($id);

        if ($userKey->delete()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'User Key Deleted!',
                    'message' => "The User Key has been successfully deleted.",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
        } else {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'Delete User Key Failed!',
                    'message' => "The User Key could not be deleted, the server encountered an error:",
                    'style' => 'danger',
                    'icon' => 'times-circle-o'
                ]));
        }

        return $this->redirect(['update', 'id' => $user_id]);
    }

    public function actionUserKeyCreate($user_id) {
        $user = $this->findModel($user_id);

        // Find and delete existing AUTH key
        $userKey = UserKey::find()->where(['user_id' => $user_id, 'type' => UserKey::TYPE_AUTH])->one();
        if (!is_null($userKey)) {
            $userKey->delete();
        }

        if ($user->generateAuthKey()) {
            UserLog::add(UserLog::ACTION_USER_KEY, UserLog::RESULT_SUCCESS, $user->id, 'Created new AUTH Key.');
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'New User AUTH Key Created!',
                    'message' => "The old AUTH key has been replaced with a new random key.",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
        } else {
            UserLog::add(UserLog::ACTION_USER_KEY, UserLog::RESULT_FAIL, $user->id, 'Failed to create new AUTH Key.');
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'New User AUTH Key Failed!',
                    'message' => "The User AUTH Key could not be regenerated, the server encountered an error:",
                    'style' => 'danger',
                    'icon' => 'times-circle-o'
                ]));
        }

        return $this->redirect(['update', 'id' => $user_id]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the UserLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUserLogModel($id) {
        if (($model = UserLog::find()->where([UserLog::getTableSchema()->name . '.id' => $id])->joinWith('user')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findUserKeyModel($id) {
        if (($model = UserKey::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}