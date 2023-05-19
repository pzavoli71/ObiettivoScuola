<?php

namespace frontend\controllers\busy;

use common\models\busy\TipoPermesso;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * TipopermessoController implements the CRUD actions for TipoPermesso model.
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipopermesso/create' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipopermesso/update' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipopermesso/delete' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipopermesso/view' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipopermesso/lista' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	
	
 */
class TipopermessoController extends BaseController
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
    public function actionLista()
    {
        $searchModel = new TipoPermesso();
        $query = TipoPermesso::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoPermesso model.
     * @param int $TpPermesso Id Doc Obiettivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($TpPermesso)
    {
        return $this->render('view', [
            'model' => $this->findModel($TpPermesso),
        ]);
    }

    /**
     * Creates a new TipoPermesso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipoPermesso();

        if ($this->request->isPost) {
			// Scommentare se ci sono campi upload
			// $filesalvato = '';
            //$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            //if (isSet($model->imageFile) && !($filesalvato = $model->upload(900))) {
                // file is uploaded successfully
            //    return;
            //}
            if ($model->load($this->request->post())) {
				// if (isSet($model->imageFile)) {
					//$model->PathDoc = $filesalvato;
				// }
                if ($model->save()) {
                    return $this->redirect(['view', 'TpPermesso'=>$model->TpPermesso]);
                }
            }
        } else {
			// Mettere qui eventuali valori da assegnare a colonne calcolate
            //$model->IdObiettivo = $this->request->queryParams['IdObiettivo'];            
						
            $model->loadDefaultValues();
        }
		// Combo da aggiungere alla maschera
		
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoPermesso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $TpPermesso Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($TpPermesso)
    {
        $model = $this->findModel($TpPermesso);

        if ($this->request->isPost) {
			// Scommentare se ci sono campi upload
			// $filesalvato = '';			
            //$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            //if (isSet($model->imageFile) && !($filesalvato = $model->upload(900))) {
                // file is uploaded successfully
            //    return;
            //}
            if ($model->load($this->request->post())) {
                //if (isSet($model->imageFile))
                //    $model->PathDoc = $filesalvato; 
                if ($model->save()) {
                    return $this->redirect(['view', 'TpPermesso'=>$model->TpPermesso]);
                }
            }
        }
		
		// Combo da aggiungere alla maschera
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoPermesso model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $TpPermesso Id 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($TpPermesso)
    {
        $model = $this->findModel($TpPermesso);
        if ( $model->delete()) {
            Yii::$app->session->setFlash('success', 'Cancellazione effettuata correttamente.Chiudere la maschera.');
            return $this->redirect(['create']);
		}			
        return $this->redirect(['view','TpPermesso'=>$model->TpPermesso]);   
    }

    /**
     * Finds the TipoPermesso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $TpPermesso Id 
     * @return TipoPermesso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($TpPermesso)
    {
        if (($model = TipoPermesso::findOne($TpPermesso)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
	 /**
     * Load relazione
     *
     * @return string
     */
    public function actionReloadrelazione($nomepdc, $nomerelaz, $TpPermesso)
	{
	    $searchModel = new tipopermessoSearch();
		if ($nomerelaz == "TipoPermesso_PermessoArg" ) 
                $dataProvider = $searchModel->searchPermessoarg($this->request->queryParams, $TpPermesso);
		
         else {
            return;
        }
			
        return $this->renderPartial('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            '$TpPermesso' => $TpPermesso,
            'nomepdc' => $nomepdc,
            'nomerelaz' => $nomerelaz,      
			'rigapos' => 1,
        ]);
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
