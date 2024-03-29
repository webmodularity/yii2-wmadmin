<?php

namespace wma\controllers;

use Yii;
use wmc\models\File;
use wmc\models\FileData;
use wma\models\FileSearch;
use wma\controllers\Controller;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use wmc\behaviors\FileUploadBehavior;
use wmc\models\FileType;
use yii\helpers\ArrayHelper;
use wmc\widgets\Alert;
use yii\helpers\Html;
use yii\filters\VerbFilter;

/**
 * FileAdminController implements the CRUD actions for File model.
 */
class FileAdminController extends Controller
{
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
                                    'actions' => ['refresh-size'],
                                    'roles' => ['su']
                                ],
                                [
                                    'allow' => false,
                                    'actions' => ['refresh-size']
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
            'attributes' => [
                ['fileTypes' => ArrayHelper::getColumn(FileType::find()->where('1=1')->all(), 'name')],
            ]
        ]);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->alertManager->add(Alert::widget(
                    [
                        'heading' => "Meeting Note Added.",
                        'message' => "Successfully added a new File with an " . Html::a('ID of ' . $model->id, ['index', 'File[id]' => $model->id], ['class' => 'alert-link']) . ".",
                        'style' => 'success',
                        'encode' => false,
                        'icon' => 'check-square-o'
                    ]));
                return $this->redirect(['index']);
            } else {
                $model->addError('upload_file', "Error while uploading file. (" . VarDumper::dumpAsString($model->getErrors()) . ")");
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
        $model->scenario = File::SCENARIO_UPDATE;
        $model->attachBehavior('fileUploadBehavior',[
            'class' => FileUploadBehavior::className(),
            'fileTypes' => ArrayHelper::getColumn(FileType::find()->where('1=1')->all(), 'id'),
            'saveFileModel' => false,
            'uploadRequired' => false
        ]);

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
        foreach (FileData::find()->where($where)->joinWith(['fileType', 'filePath'])->all() as $file) {
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
        if (($model = File::find()->where(['id' => $id])->joinWith('primaryExtension')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}