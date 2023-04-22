<?php

namespace frontend\controllers\soggetti;

use common\models\soggetti\Soggetto;
use common\models\soggetti\SoggettoSearch;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * SoggettoController implements the CRUD actions for Soggetto model
 */
class SoggettoController extends BaseController
{
    public $layout = "mainform";
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
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SoggettoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Soggetto model.
     * @param int $IdSoggetto Id Doc Obiettivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdSoggetto = 0)
    {
        $model = null;
        if ( $IdSoggetto == 0) {
            if (($model = Soggetto::findOne(['id'=>\Yii::$app->user->identity->getId()])) !== null) {
                return $this->render('view', [
                    'model' => $model,
                ]);                
            }
        }
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
			// Scommentare se ci sono campi upload
            //$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            //if (!$model->upload()) {
                // file is uploaded successfully
            //    return;
            //}
            if ($model->load($this->request->post())) {
                //$model->PathDoc = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                if ($model->save()) {
                    return $this->redirect(['view', 'IdSoggetto'=>$model->IdSoggetto]);
                }
            }
        } else {
			// Mettere qui eventuali valori da assegnare a colonne calcolate
            //$model->IdObiettivo = $this->request->queryParams['IdObiettivo'];            
						
            $model->loadDefaultValues();
        }
		// Combo da aggiungere alla maschera
		
		$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		$this->addCombo('User', $items);          		
		
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Soggetto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdSoggetto Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdSoggetto)
    {
        $model = $this->findModel($IdSoggetto);

        if ($this->request->isPost) {
			// Scommentare se ci sono campi upload
            //$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            //if (isSet($model->imageFile) && !$model->upload()) {
                // file is uploaded successfully
            //    return;
            //}
            if ($model->load($this->request->post())) {
                //if (isSet($model->imageFile))
                //    $model->PathDoc = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                if ($model->save()) {
                    return $this->redirect(['view', 'IdSoggetto'=>$model->IdSoggetto]);
                }
            }
        }
		
		$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		$this->addCombo('User', $items);          		
		
		// Combo da aggiungere alla maschera
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Soggetto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdSoggetto Id 
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
     * @param int $IdSoggetto Id 
     * @return Soggetto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdSoggetto)
    {
        if (($model = Soggetto::findOne($IdSoggetto)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }  
}
