<?php

namespace frontend\controllers\busy;

use common\models\busy\Obiettivo;
use common\models\busy\ObiettivoSearch;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii; 

/**
 * ObiettivoController implements the CRUD actions for Obiettivo model.
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/obiettivo/create' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/obiettivo/update' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/obiettivo/delete' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/obiettivo/view' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
 * 	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/obiettivo/lista' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	
 */
class ObiettivoController extends BaseController
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
                'corsFilter' => [
                    'class' => \yii\filters\Cors::className(),
                    'cors' => [],
                    'actions' => [
                        'incoming' => [
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                            'Access-Control-Allow-Credentials' => null,
                            'Access-Control-Max-Age' => 86400,
                            'Access-Control-Expose-Headers' => [],
                        ],
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
        $searchModel = new ObiettivoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $items = ArrayHelper::map(\common\models\Soggetto::find()->all(), 'IdSoggetto', 'NomeSoggetto');
        $this->addCombo('Soggetto', $items);          		

        $items = ArrayHelper::map(\common\models\TipoOccupazione::find()->all(), 'TpOccup', 'DsOccup');
        $this->addCombo('TipoOccupazione', $items);     		
        
        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Obiettivo model.
     * @param int $IdObiettivo Id Doc Obiettivo
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
        $model = new Obiettivo();

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
                    return $this->redirect(['view', 'IdObiettivo'=>$model->IdObiettivo]);
                }
            }
        } else {
			// Mettere qui eventuali valori da assegnare a colonne calcolate
            $model->IdSoggetto = \Yii::$app->user->identity->soggetto->IdSoggetto;
            $model->DtInizioObiettivo = BaseController::getToday();
            $model->loadDefaultValues();
        }
		// Combo da aggiungere alla maschera
		
		$items = ArrayHelper::map(\common\models\Soggetto::find()->all(), 'IdSoggetto', 'NomeSoggetto');
		$this->addCombo('Soggetto', $items);          		
		
		$items = ArrayHelper::map(\common\models\TipoOccupazione::find()->all(), 'TpOccup', 'DsOccup');
		$this->addCombo('TipoOccupazione', $items);     		
		
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Obiettivo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdObiettivo Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdObiettivo)
    {
        $model = $this->findModel($IdObiettivo);

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
                    return $this->redirect(['view', 'IdObiettivo'=>$model->IdObiettivo]);
                }
            }
        }
		
		$items = ArrayHelper::map(\common\models\Soggetto::find()->all(), 'IdSoggetto', 'NomeSoggetto');
		$this->addCombo('Soggetto', $items);          		
		
		$items = ArrayHelper::map(\common\models\TipoOccupazione::find()->all(), 'TpOccup', 'DsOccup');
		$this->addCombo('TipoOccupazione', $items);          		
		
		// Combo da aggiungere alla maschera
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Obiettivo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdObiettivo Id 
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
     * @param int $IdObiettivo Id 
     * @return Obiettivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdObiettivo)
    {
        if (($model = Obiettivo::findOne($IdObiettivo)) !== null) {
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
    
    /**
     * Load relazione
     *
     * @return string
     */
    public function actionReloadrelazione($nomepdc, $nomerelaz, $IdObiettivo)
    {
        $searchModel = new ObiettivoSearch();
        if ($nomerelaz == "Obiettivo_Lavoro" ) 
                $dataProvider = $searchModel->searchLavoro($this->request->queryParams, $IdObiettivo);
        else if ( $nomerelaz == "Obiettivo_DocObiettivo") {
                //$searchModel = new DomandaQuizSearch();
                $dataProvider = $searchModel->searchDocobiettivo($this->request->queryParams, $IdObiettivo);
        } else {
            return;
        }
			
        return $this->renderPartial('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'IdObiettivo' => $IdObiettivo,
            'nomepdc' => $nomepdc,
            'nomerelaz' => $nomerelaz,      
			'rigapos' => 1,
        ]);
    }    
    
    /**
     * Updates an existing Lavoro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdLavoro Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChiudilavoro()
    {
        $model = null;
        
        if (!Yii::$app->request->isAjax) {
            throw new UserException('Non è chiamata ajax.');
        }
        $data = \Yii::$app->request->post();
        $id = $data['IdLavoro'];
        $IdLavoro= explode(":", $data['IdLavoro']);
        //$searchby= explode(":", $data['searchby']);
        $IdLavoro= $IdLavoro[0];
        //$searchby= $searchby[0];
        $search = // your logic;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          
        if (($model = \common\models\busy\Lavoro::findOne($IdLavoro)) == null) {
            throw new UserException('Errore durante la lettura della riga lavoro.');
        }
       
        if ( $model != null) {
            $model->OraFine = date('H');
            $model->MinutiFine = date('i');
            $nota= explode(":", $data['NotaLavoro']);
            $nota= $nota[0];
            $model->NotaLavoro = $nota;
            if ( !$model->save()) {
                throw new UserException('Errore durante la chiusura della riga lavoro.');
            }
            return [
                'errore' => '',
                'code' => 100,
            ];
        }     
        return [
            'errore' => 'Non trovato il lavoro',
            'code' => 100,
        ];        
    }        
    
    public function beforeAction($action):bool
    {
        /*if (in_array($action->id, ['chiudilavoro'])) {
            $this->enableCsrfValidation = false;
        }*/
        return parent::beforeAction($action);
    }    
}
