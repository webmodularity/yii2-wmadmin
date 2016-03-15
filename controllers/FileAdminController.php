<?php

namespace wma\controllers;

use Yii;
use wmc\models\File;
use wma\models\FileSearch;
use wma\controllers\Controller;
use yii\web\NotFoundHttpException;
use wmc\behaviors\FileUploadBehavior;

/**
 * FileAdminController implements the CRUD actions for File model.
 */
class FileAdminController extends Controller
{
    /**
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@wma/views/file-admin/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single File model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new File(['inline' => true, 'status' => 1]);
        $model->attachBehavior('fileUploadBehavior',[
            'class' => FileUploadBehavior::className(),
            'pathAttribute' => 'file_path_id',
            'saveFileModel' => false
        ]);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                $model->addError('upload_file', "Error while uploading file.");
            }
        }

        return $this->render('@wma/views/file-admin/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('@wma/views/file-admin/update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRefreshSize($pathId = 0) {
        $where = [];
        if (is_int($pathId) && $pathId > 0) {
            $where['file_path_id'] = $pathId;
        }
        Yii::warning("File Admin refreshSize action started.");
        $count = $countChanged = $countError = 0;
        foreach (File::find()->where($where)->joinWith(['fileType', 'filePath'])->all() as $file) {
            $count++;
            $actualBytes = @filesize(Yii::getAlias($file->filePath->path) . DIRECTORY_SEPARATOR . $file->fullAlias);
            if ($actualBytes === false) {
                $countError++;
                Yii::warning("Unable to get filesize() of [".Yii::getAlias($file->filePath->path) . DIRECTORY_SEPARATOR . $file->fullAlias."]!");
            } else if ($actualBytes != $file->bytes) {
                $file->bytes = $actualBytes;
                if (!$file->save(true, ['bytes'])) {
                    $countError++;
                    Yii::warning("Failed to update bytes to [".$actualBytes."] for file [ID: ".$file->id."].");
                } else {
                    $countChanged++;
                }
            }
        }
        Yii::warning("File Admin refreshSize action finished. Summary: [".$count."] Files scanned, [".$countChanged."] Files updated, [".$countError."] Errors.");
        $this->redirect(['index']);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}