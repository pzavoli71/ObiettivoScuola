<?php

namespace frontend\controllers;

use common\models\Docobiettivo;
use common\models\DocobiettivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocobiettivoController implements the CRUD actions for Docobiettivo model.
 */
class DocobiettivoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Docobiettivo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DocobiettivoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docobiettivo model.
     * @param int $IdDocObiettivo Id Doc Obiettivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdDocObiettivo)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdDocObiettivo),
        ]);
    }

    /**
     * Creates a new Docobiettivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Docobiettivo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'IdDocObiettivo' => $model->IdDocObiettivo]);
            }
        } else {
            $model->IdObiettivo = $this->request->queryParams['IdObiettivo'];            
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Docobiettivo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdDocObiettivo Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdDocObiettivo)
    {
        $model = $this->findModel($IdDocObiettivo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'IdDocObiettivo' => $model->IdDocObiettivo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Docobiettivo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdDocObiettivo Id Doc Obiettivo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdDocObiettivo)
    {
        $this->findModel($IdDocObiettivo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Docobiettivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdDocObiettivo Id Doc Obiettivo
     * @return Docobiettivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdDocObiettivo)
    {
        if (($model = Docobiettivo::findOne(['IdDocObiettivo' => $IdDocObiettivo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
  
}
