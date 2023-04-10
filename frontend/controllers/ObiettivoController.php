<?php

namespace frontend\controllers;

use common\models\Obiettivo;
use common\models\ObiettivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * ObiettivoController implements the CRUD actions for Obiettivo model.
 */
class ObiettivoController extends Controller
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
     * Lists all Obiettivo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $items = ArrayHelper::map(\common\models\Soggetto::find()->all(), 'IdSoggetto', 'NomeSoggetto');
        
        $searchModel = new ObiettivoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'items'=>$items
        ]);
    }

    /**
     * Displays a single Obiettivo model.
     * @param int $IdObiettivo Id Obiettivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdObiettivo)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdObiettivo),
        ]);
    }

    /**
     * Creates a new Obiettivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $items = ArrayHelper::map(\common\models\Soggetto::find()->all(), 'IdSoggetto', 'NomeSoggetto');
        $itemsTpOccup = ArrayHelper::map(\common\models\Tipooccupazione::find()->all(), 'TpOccup', 'DsOccup');
        
        $model = new Obiettivo();

        if ( $this->request->isAjax) {
            if ($model->load($this->request->post())) {
                $this->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }    
        } else if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'IdObiettivo' => $model->IdObiettivo]);
            }  
        } 
        else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'items'=>$items,
            'itemsTpOccup'=>$itemsTpOccup,            
        ]);
    }

    /**
     * Updates an existing Obiettivo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdObiettivo Id Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdObiettivo)
    {
        $items = ArrayHelper::map(\common\models\Soggetto::find()->all(), 'IdSoggetto', 'NomeSoggetto');        
        $itemsTpOccup = ArrayHelper::map(\common\models\Tipooccupazione::find()->all(), 'TpOccup', 'DsOccup');
        $model = $this->findModel($IdObiettivo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'IdObiettivo' => $model->IdObiettivo]);
        }

        return $this->render('update', [
            'model' => $model,
            'items' => $items,
            'itemsTpOccup'=>$itemsTpOccup,            
        ]);
    }

    /**
     * Deletes an existing Obiettivo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdObiettivo Id Obiettivo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdObiettivo)
    {
        $this->findModel($IdObiettivo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Obiettivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdObiettivo Id Obiettivo
     * @return Obiettivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdObiettivo)
    {
        if (($model = Obiettivo::findOne(['IdObiettivo' => $IdObiettivo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionViewdocs()
    {
         if(isset($_POST['expandRowKey'])) {  
             $model = $this->findModel($_POST['expandRowKey']);  
             //$variable= $anydata; //anydata want to send in expanded view  
             return $this->renderPartial('viewdocs.php',['model'=>$model]);  
        }  
        else  
        {  
           return '<div class="alert alert-danger">No data found</div>';  

        }  
    }
}
