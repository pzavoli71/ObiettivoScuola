<?php

namespace frontend\controllers\busy;

use common\models\busy\Argomento;
use common\models\busy\ArgomentoSearch;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * ArgomentoController implements the CRUD actions for Argomento model.
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/argomento/create' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/argomento/update' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/argomento/delete' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/argomento/view' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	
 */
class ArgomentoController extends BaseController
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
        $searchModel = new ArgomentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Argomento model.
     * @param int $IdArg Id Doc Obiettivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdArg)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdArg),
        ]);
    }

    /**
     * Creates a new Argomento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Argomento();

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
                    return $this->redirect(['view', 'IdArg'=>$model->IdArg]);
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
     * Updates an existing Argomento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdArg Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdArg)
    {
        $model = $this->findModel($IdArg);

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
                    return $this->redirect(['view', 'IdArg'=>$model->IdArg]);
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
     * Deletes an existing Argomento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdArg Id 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdArg)
    {
        $model = $this->findModel($IdArg);
        if ( $model->delete()) {
            Yii::$app->session->setFlash('success', 'Cancellazione effettuata correttamente.Chiudere la maschera.');
            return $this->redirect(['create']);
		}			
        return $this->redirect(['view','IdArg'=>$model->IdArg]);   
    }

    /**
     * Finds the Argomento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdArg Id 
     * @return Argomento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdArg)
    {
        if (($model = Argomento::findOne($IdArg)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
	 /**
     * Load relazione
     *
     * @return string
     */
    public function actionReloadrelazione($nomepdc, $nomerelaz, $IdArg)
	{
	    $searchModel = new argomentoSearch();
		if ($nomerelaz == "Argomento_TipoOccupazione" ) 
                $dataProvider = $searchModel->searchTipooccupazione($this->request->queryParams, $IdArg);
		else if ($nomerelaz == "Argomento_Obiettivo" ) 
                $dataProvider = $searchModel->searchObiettivo($this->request->queryParams, $IdArg);
		else if ($nomerelaz == "Argomento_PermessoArg" ) 
                $dataProvider = $searchModel->searchPermessoarg($this->request->queryParams, $IdArg);
		
         else {
            return;
        }
			
        return $this->renderPartial('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            '$IdArg' => $IdArg,
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
