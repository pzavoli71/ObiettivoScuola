<?php

namespace backend\controllers;

use app\models\TipoOccupazione;
use app\models\TipoOccupazioneSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * TipoOccupazioneController implements the CRUD actions for TipoOccupazione model.
 */
class TipooccupazioneController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'error'],
                            'allow' => true,
                        ],
                        [
                            'actions' => ['index','create','view','delete','update'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],                
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
     * Lists all TipoOccupazione models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TipoOccupazioneSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoOccupazione model.
     * @param int $TpOccup Tp Occup
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($TpOccup)
    {
        return $this->render('view', [
            'model' => $this->findModel($TpOccup),
        ]);
    }

    /**
     * Creates a new TipoOccupazione model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipoOccupazione();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'TpOccup' => $model->TpOccup]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoOccupazione model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $TpOccup Tp Occup
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($TpOccup)
    {
        $model = $this->findModel($TpOccup);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'TpOccup' => $model->TpOccup]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoOccupazione model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $TpOccup Tp Occup
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($TpOccup)
    {
        $this->findModel($TpOccup)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoOccupazione model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $TpOccup Tp Occup
     * @return TipoOccupazione the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($TpOccup)
    {
        if (($model = TipoOccupazione::findOne(['TpOccup' => $TpOccup])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
