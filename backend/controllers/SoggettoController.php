<?php

namespace backend\controllers;

use common\models\Soggetto;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SoggettoController implements the CRUD actions for Soggetto model.
 */
class SoggettoController extends Controller
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
     * Lists all Soggetto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Soggetto::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'IdSoggetto' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Soggetto model.
     * @param int $IdSoggetto Id Soggetto
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdSoggetto)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdSoggetto),
        ]);
    }

    /**
     * Creates a new Soggetto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Soggetto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'IdSoggetto' => $model->IdSoggetto]);
            }
        } else {
            $model->id = $this->request->queryParams['id'];
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Soggetto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdSoggetto Id Soggetto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdSoggetto)
    {
        $model = $this->findModel($IdSoggetto);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'IdSoggetto' => $model->IdSoggetto]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Soggetto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdSoggetto Id Soggetto
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdSoggetto)
    {
        $this->findModel($IdSoggetto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Soggetto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdSoggetto Id Soggetto
     * @return Soggetto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdSoggetto)
    {
        if (($model = Soggetto::findOne(['IdSoggetto' => $IdSoggetto])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
