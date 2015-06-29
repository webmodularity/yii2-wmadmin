<?php

namespace wma\controllers;

use Yii;
use wma\models\MenuForm;
use wma\models\MenuSearch;
use wmc\models\Menu;
use wma\models\MenuItemForm;
use wma\models\MenuItemPositionForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use wma\widgets\Alert;

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
                        'class' => \yii\filters\AccessControl::className(),
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
                        'delete-item' => ['post']
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
        $model = new Menu();
        $addModel = new MenuForm();

        if (Yii::$app->request->isPost === true && $addModel->load(Yii::$app->request->post()) && $addModel->save()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Add Successful!",
                    'message' => "The Menu (".$addModel->name.") has been inserted.",
                    'style' => 'success',
                    'block' => true,
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        }

        return $this->render('@wma/views/menu/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'addModel' => $addModel
        ]);
    }

    /**
     * View/update root node as well as CRUD for MenuItems
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $menu = $this->findModel($id);
        $menuForm = new MenuForm(['menu_id' => $menu->id, 'name' => $menu->name, 'icon' => $menu->icon]);
        $menuItemForm = new MenuItemForm(['position' => new MenuItemPositionForm()]);

        if ($menuItemForm->load(Yii::$app->request->post(), "MenuItemForm")
            && $menuItemForm->position->load(Yii::$app->request->post(), "MenuItemPositionForm")
            && $menuItemForm->position->validate()
        ) {
            if ($menuItemForm->save()) {
                Yii::$app->alertManager->add(Alert::widget(
                    [
                        'heading' => "Menu " . $menuItemForm->typeName . " Added!",
                        'message' => "Successfully added a new Menu " . $menuItemForm->typeName . ": (" . $menuItemForm->name . ")",
                        'style' => 'success',
                        'block' => true,
                        'icon' => 'check-square-o'
                    ]));
                return $this->refresh();
            }
        } else if ($menuForm->load(Yii::$app->request->post()) && $menuForm->save()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu Updated!",
                    'message' => "Successfully updated ".$menuForm->name."",
                    'style' => 'success',
                    'block' => true,
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        }

        if ($menuItemForm->hasErrors()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu ".$menuItemForm->typeName." Add Failed!",
                    'message' => "Failed to add new ".$menuItemForm->typeName." to Menu!",
                    'style' => 'danger',
                    'block' => true,
                    'icon' => 'times-circle-o'
                ]));
        }

        return $this->render('@wma/views/menu/update', [
            'menu' => $menu,
            'menuForm' => $menuForm,
            'menuItemForm' => $menuItemForm
        ]);
    }

    public function actionUpdateItem($id) {
        $menuItem = $this->findItemModel($id);
        $menu = $this->findModel($menuItem->tree_id);
        $menuItemForm = new MenuItemForm(
            [
                'id' => $menuItem->id,
                'type' => $menuItem->type,
                'name' => $menuItem->name,
                'link' => $menuItem->link,
                'icon' => $menuItem->icon,
                'user_groups' => ArrayHelper::getColumn($menuItem->userGroups, 'id'),
                'position' => new MenuItemPositionForm()
            ]
        );

        if ($menuItemForm->load(Yii::$app->request->post(), "MenuItemForm") && $menuItemForm->save()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu " . $menuItemForm->typeName . " Updated!",
                    'message' => "Successfully updated " . $menuItemForm->typeName . ": (" . $menuItemForm->name . ")",
                    'style' => 'success',
                    'block' => true,
                    'icon' => 'check-square-o'
                ]));
            return $this->refresh();
        } else if ($menuItemForm->position->load(Yii::$app->request->post(), "MenuItemPositionForm") && $menuItemForm->position->validate()) {
            if ($menuAttach = Menu::findOne($menuItemForm->position->item_id)) {
                if ($menuItemForm->position->moveItem($menuItem, $menuAttach)) {
                    Yii::$app->alertManager->add(Alert::widget(
                        [
                            'heading' => "Menu " . $menuItemForm->typeName . " Moved!",
                            'message' => "Successfully moved " . $menuItemForm->typeName . ": (" . $menuItemForm->name . ")",
                            'style' => 'success',
                            'block' => true,
                            'icon' => 'check-square-o'
                        ]));
                    return $this->refresh();
                } else {
                    Yii::$app->alertManager->add(Alert::widget(
                        [
                            'heading' => "Menu Move Failed!",
                            'message' => "Failed to move ".$menuItemForm->name."",
                            'style' => 'danger',
                            'block' => true,
                            'icon' => 'times-circle-o'
                        ]));
                }
            } else {
                $menuItemForm->addError('item_id', "Could not locate the specified Menu Item.");
            }
        }

        if ($menuItemForm->hasErrors()) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => "Menu Update Failed!",
                    'message' => "Failed to update ".$menuItemForm->name."",
                    'style' => 'danger',
                    'block' => true,
                    'icon' => 'times-circle-o'
                ]));
        }

        return $this->render('@wma/views/menu/update-item', [
            'menu' => $menu,
            'menuItemForm' => $menuItemForm
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        try {
            $error = false;
            $deleted = $this->findModel($id)->deleteWithChildren();
            if ($deleted === false) {
                $error = "Delete Failed";
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        if ($error !== false) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'Delete Failed!',
                    'message' => "The Menu could not be deleted, the server encountered an error: (".$error.")",
                    'style' => 'danger',
                    'block' => true,
                    'icon' => 'times-circle-o'
                ]));
        } else {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'Menu Deleted!',
                    'message' => "The Menu has been removed from the database.",
                    'style' => 'success',
                    'block' => true,
                    'icon' => 'check-square-o'
                ]));
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteItem($id) {
        try {
            $error = false;
            $menuItem = $this->findItemModel($id);
            $treeId = $menuItem->tree_id;
            $deleted = $menuItem->deleteWithChildren();
            if ($deleted === false) {
                $error = "Delete Failed";
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        if ($error !== false) {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'Menu Item Delete Failed!',
                    'message' => "The Menu Item could not be deleted, the server encountered an error: (".$error.")",
                    'style' => 'danger',
                    'block' => true,
                    'icon' => 'times-circle-o'
                ]));
            return $this->refresh();
        } else {
            Yii::$app->alertManager->add(Alert::widget(
                [
                    'heading' => 'Menu Item Deleted!',
                    'message' => "The Menu Item has been removed from the database.",
                    'style' => 'success',
                    'block' => true,
                    'icon' => 'check-square-o'
                ]));
            return $this->redirect(['update', 'id' => $treeId]);
        }
    }

    /**
     * Finds the (ROOT) Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::find()->where(['id' => $id])->roots()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the (NON-ROOT) Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findItemModel($id)
    {
        if (($model = Menu::find()->where(['id' => $id])->nonRoots()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}