<?php

namespace frontend\controllers\busy;

use common\models\busy\TipoOccupazione;
use common\models\busy\TipoOccupazioneSearch;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * TipooccupazioneController implements the CRUD actions for TipoOccupazione model.
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipooccupazione/create' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipooccupazione/update' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipooccupazione/delete' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/tipooccupazione/view' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	
 */
class TipooccupazioneController extends BaseController
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
        $searchModel = new TipoOccupazioneSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $items = ArrayHelper::map(\common\models\busy\Argomento::find()->all(), 'IdArg', 'DsArgomento');
        $this->addCombo('Argomento', $items);     		
        
        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoOccupazione model.
     * @param int $TpOccup Id Doc Obiettivo
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
			// Scommentare se ci sono campi upload
            //$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            //if (!$model->upload()) {
                // file is uploaded successfully
            //    return;
            //}
            if ($model->load($this->request->post())) {
                //$model->PathDoc = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                if ($model->save()) {
                    return $this->redirect(['view', 'TpOccup'=>$model->TpOccup]);
                }
            }
        } else {
			// Mettere qui eventuali valori da assegnare a colonne calcolate
            if ( !is_null($this->request->get('IdArg')))
                $model->IdArg = $this->request->get('IdArg');            						
            $model->loadDefaultValues();
        }
		// Combo da aggiungere alla maschera
		
        $items = ArrayHelper::map(\common\models\busy\Argomento::find()->all(), 'IdArg', 'DsArgomento');
        $this->addCombo('Argomento', $items);          

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoOccupazione model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $TpOccup Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($TpOccup)
    {
        $model = $this->findModel($TpOccup);

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
                    return $this->redirect(['view', 'TpOccup'=>$model->TpOccup]);
                }
            }
        }
		
        $items = ArrayHelper::map(\common\models\busy\Argomento::find()->all(), 'IdArg', 'DsArgomento');
        $this->addCombo('Argomento', $items);          

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionCombo($context = null, $nomecombo = null, $currvalue = null) {
        if ( $context === 'dynamic') {

        } else {
            $items = ArrayHelper::map(\common\models\busy\Argomento::find()->all(), 'IdArg', 'DsArgomento');
            $this->addCombo('Argomento', $items);                  
        }
    }
    /**
     * Deletes an existing TipoOccupazione model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $TpOccup Id 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($TpOccup)
    {
        $model = $this->findModel($TpOccup);
        if ($model->delete()) {
            \Yii::$app->session->setFlash('success', 'Cancellazione effettuata correttamente.Chiudere la maschera.');
            return $this->redirect(['create','TpOccup'=>$model->TpOccup]);
        }
        return $this->redirect(['view','TpOccup'=>$TpOccup]);
    }

    /**
     * Finds the TipoOccupazione model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $TpOccup Id 
     * @return TipoOccupazione the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($TpOccup)
    {
        if (($model = TipoOccupazione::findOne($TpOccup)) !== null) {
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
