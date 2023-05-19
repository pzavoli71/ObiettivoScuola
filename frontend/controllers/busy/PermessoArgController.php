<?php

namespace frontend\controllers\busy;

use common\models\busy\PermessoArg;
use common\models\busy\PermessoArgSearch;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * PermessoargController implements the CRUD actions for PermessoArg model.
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/permessoarg/create' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/permessoarg/update' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/permessoarg/delete' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/permessoarg/view' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/permessoarg/lista' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	
	
 */
class PermessoargController extends BaseController
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
        $searchModel = new PermessoArgSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PermessoArg model.
     * @param int $IdPermessoArg Id Doc Obiettivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdPermessoArg)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdPermessoArg),
        ]);
    }

    /**
     * Creates a new PermessoArg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PermessoArg();

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
                    return $this->redirect(['view', 'IdPermessoArg'=>$model->IdPermessoArg]);
                }
            }
        } else {
			// Mettere qui eventuali valori da assegnare a colonne calcolate
            $model->IdArg = $this->request->queryParams['IdArg'];            						
            //$model->load($this->request->queryParams);
            $model->loadDefaultValues();
        }
		// Combo da aggiungere alla maschera
		
		$items = ArrayHelper::map(\common\models\soggetti\Soggetto::find()->all(), 'IdSoggetto', 'NomeSoggetto');
		$this->addCombo('Soggetto', $items);          		
		
		$items = ArrayHelper::map(\common\models\busy\Argomento::find()->all(), 'IdArg', 'DsArgomento');
		$this->addCombo('Argomento', $items);          		
		
		$items = ArrayHelper::map(\common\models\busy\TipoPermesso::find()->all(), 'TpPermesso', 'DsPermesso');
		$this->addCombo('TipoPermesso', $items);          		
		
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PermessoArg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdPermessoArg Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdPermessoArg)
    {
        $model = $this->findModel($IdPermessoArg);

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
                    return $this->redirect(['view', 'IdPermessoArg'=>$model->IdPermessoArg]);
                }
            }
        }
		
		$items = ArrayHelper::map(\common\models\soggetti\Soggetto::find()->all(), 'IdSoggetto', 'NomeSoggetto');
		$this->addCombo('Soggetto', $items);          		
		
		$items = ArrayHelper::map(\common\models\busy\Argomento::find()->all(), 'IdArg', 'DsArgomento');
		$this->addCombo('Argomento', $items);          		
		
		$items = ArrayHelper::map(\common\models\busy\TipoPermesso::find()->all(), 'TpPermesso', 'DsPermesso');
		$this->addCombo('TipoPermesso', $items);          		
		
		// Combo da aggiungere alla maschera
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PermessoArg model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdPermessoArg Id 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdPermessoArg)
    {
        $model = $this->findModel($IdPermessoArg);
        if ( $model->delete()) {
            Yii::$app->session->setFlash('success', 'Cancellazione effettuata correttamente.Chiudere la maschera.');
            return $this->redirect(['create']);
		}			
        return $this->redirect(['view','IdPermessoArg'=>$model->IdPermessoArg]);   
    }

    /**
     * Finds the PermessoArg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdPermessoArg Id 
     * @return PermessoArg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdPermessoArg)
    {
        if (($model = PermessoArg::findOne($IdPermessoArg)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
	 /**
     * Load relazione
     *
     * @return string
     */
    public function actionReloadrelazione($nomepdc, $nomerelaz, $IdPermessoArg)
	{
	 /*   $searchModel = new permessoargSearch();
		
         else {
            return;
        }
			
        return $this->renderPartial('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            '$IdPermessoArg' => $IdPermessoArg,
            'nomepdc' => $nomepdc,
            'nomerelaz' => $nomerelaz,      
			'rigapos' => 1,
        ]);*/
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
