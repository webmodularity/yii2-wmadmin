<?php

namespace wma\controllers;

use Yii;
use wmc\models\Menu;
use wma\models\MenuSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use wma\widgets\Alert;
use wmc\models\user\UserGroup;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends \wma\controllers\Controller
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
            [
                'access' =>
                    [
                        'class' => AccessControl::className(),
                        'rules' =>
                            [
                                [
                                    'allow' => true,
                                    'roles' => ['su'],
                                ]
                            ]
                    ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['post'],
                        'delete-item' => ['post'],
                        'move-item' => ['post']
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ROOT (depth=0) Menu models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Menu(['type' => Menu::TYPE_ROOT]);

        if (Yii::$app->request->isPost === true && $model->load(Yii::$app->request->post()) && $model->makeRoot()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Add Successful!",
                    'message' => "The Menu (".$model->name.") has been inserted.",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        }

        return $this->render('@wma/views/menu/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * View/update root node as well as CRUD for MenuItems
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the menu is not a root node
     */
    public function actionUpdate($id) {
        $menu = $this->findModel($id, 1);
        if ($menu->type !== Menu::TYPE_ROOT) {
            throw new NotFoundHttpException("The requested page doesn't exist");
        }
        $menuItem = new Menu(
            [
                'tree_id' => $menu->id,
                'type' => Menu::TYPE_LINK,
                'userGroupIds' =>
                    [
                        UserGroup::GUEST,
                        UserGroup::USER,
                        UserGroup::AUTHOR,
                        UserGroup::ADMIN,
                        UserGroup::SU

                    ]
            ]);
        $menuItem->setScenario('move');

        $postData = Yii::$app->request->isPost ? Yii::$app->request->post() : null;
        $postMenuUpdate = !is_null($postData) && $postData['Menu']['type'] == Menu::TYPE_ROOT ? true : false;
        $postAddItem = !is_null($postData) && $postData['Menu']['type'] != Menu::TYPE_ROOT ? true : false;

        if ($postMenuUpdate && $menu->load($postData)  && $menu->save()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu Updated!",
                    'message' => "Successfully updated ".$menu->name."",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        } else if ($postAddItem && $menuItem->load($postData) && $menuItem->saveNode()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu Item Added!",
                    'message' => "Successfully added a new Menu Item: (" . $menuItem->name . ")",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        }

        return $this->render('@wma/views/menu/update', [
            'menu' => $menu,
            'menuItem' => $menuItem
        ]);
    }

    public function actionUpdateItem($id) {
        $menuItem = $this->findModel($id, 2);
        $menu = $this->findModel($menuItem->tree_id, 1);
        $menuMove = $this->findModel($id, 2);
        $menuMove->setScenario('move');

        if ($menuItem->load(Yii::$app->request->post()) && $menuItem->save()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu Item Updated!",
                    'message' => "Successfully updated: " . $menuItem->name . "",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        }

        return $this->render('@wma/views/menu/update-item', [
            'menu' => $menu,
            'menuItem' => $menuItem,
            'menuMove' => $menuMove
        ]);
    }

    public function actionMoveItem() {
        $postData = Yii::$app->request->post('Menu');
        $menuItem = $this->findModel($postData['id'], 2);
        $menuItem->setScenario('move');

        if ($menuItem->load(Yii::$app->request->post()) && $menuItem->saveNode()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu Item Moved!",
                    'message' => "Successfully moved: " . $menuItem->name . "",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
        } else {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu Move Failed!",
                    'message' => "Failed to move ".$menuItem->name."",
                    'style' => 'danger',
                    'icon' => 'times-circle-o'
                ]));
        }
        return $this->redirect(['update-item', 'id' => $postData['id']]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->type == Menu::TYPE_ROOT) {
            $redirectUrl = ['index'];
            $itemText = '';
        } else {
            $redirectUrl = ['update', 'id' => $model->tree_id];
            $itemText = ' Item';
        }

        if ($model->deleteWithChildren()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu".$itemText." Deleted!",
                    'message' => "The Menu".$itemText." has been removed from the database.",
                    'style' => 'success',
                    'icon' => 'check-square-o'
                ]));
        } else {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'Delete Failed!',
                    'message' => "The Menu".$itemText." could not be deleted, the server encountered an internal error!",
                    'style' => 'danger',
                    'icon' => 'times-circle-o'
                ]));
        }

        return $this->redirect($redirectUrl);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $rootConfig [0 => Both Root + Non Root Types, 1 => Force Root Type, 2 => Force Non Root Type]
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $rootConfig = 0) {
        $query = Menu::find()->where(['id' => $id])->limit(1);
        if ($rootConfig === 1) {
            $query = $query->roots();
        } else if ($rootConfig === 2) {
            $query = $query->nonRoots();
        }

        $model = $query->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}