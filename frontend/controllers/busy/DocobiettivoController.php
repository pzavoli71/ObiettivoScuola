<?php

namespace frontend\controllers\busy;

use common\models\busy\DocObiettivo;
use common\models\busy\DocObiettivoSearch;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * DocobiettivoController implements the CRUD actions for DocObiettivo model.
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/docobiettivo/create' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/docobiettivo/update' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/docobiettivo/delete' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/docobiettivo/view' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('busy/docobiettivo/index' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	
 */
class DocobiettivoController extends BaseController
{
    public $layout = "mainform";
    public $imageFile;
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
        $searchModel = new DocObiettivoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocObiettivo model.
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
     * Creates a new DocObiettivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DocObiettivo();

        if ($this->request->isPost) {
            // Scommentare se ci sono campi upload
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $filesalvato = '';
            if (isSet($model->imageFile) && !($filesalvato = $model->upload())) {
                // file is not uploaded successfully
                return;
            }
            if ($model->load($this->request->post())) {
                if (isSet($model->imageFile)) {
                    $model->PathDoc = $filesalvato; //$model->imageFile->baseName . '.' . $model->imageFile->extension;
                }
                if ($model->save()) {
                    return $this->redirect(['view', 'IdDocObiettivo'=>$model->IdDocObiettivo]);
                }
            }
        } else {
			// Mettere qui eventuali valori da assegnare a colonne calcolate
            $model->IdObiettivo = $this->request->queryParams['IdObiettivo'];            						
            $model->DtDoc = BaseController::getToday();            
            $model->loadDefaultValues();
        }
		// Combo da aggiungere alla maschera
		
		$items = ArrayHelper::map(\common\models\busy\Obiettivo::find()->all(), 'id', 'username');
		$this->addCombo('Obiettivo', $items);          		
		
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocObiettivo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdDocObiettivo Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdDocObiettivo)
    {
        $model = $this->findModel($IdDocObiettivo);

        if ($this->request->isPost) {
	// Scommentare se ci sono campi upload
            $filesalvato = '';
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (isSet($model->imageFile) && !$filesalvato = $model->upload($model->IdObiettivo)) {
                // file is uploaded successfully
                return;
            }
            if ($model->load($this->request->post())) {
                if (isSet($model->imageFile))
                    $model->PathDoc = $filesalvato; //$model->imageFile->baseName . '.' . $model->imageFile->extension;
                if ($model->save()) {
                    return $this->redirect(['view', 'IdDocObiettivo'=>$model->IdDocObiettivo]);
                }
            }
        }
		
		$items = ArrayHelper::map(\common\models\busy\Obiettivo::find()->all(), 'id', 'username');
		$this->addCombo('Obiettivo', $items);          		
		
		// Combo da aggiungere alla maschera
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocObiettivo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdDocObiettivo Id 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdDocObiettivo)
    {
        $model = $this->findModel($IdDocObiettivo);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Cancellazione effettuata correttamente.Chiudere la maschera.');
            //echo 'Comando terminato correttamente. Chiudere la maschera';
            return $this->redirect(['create','IdObiettivo'=>$model->IdObiettivo]);
        }
        return $this->redirect(['view','IdObiettivo'=>0]);
    }

    /**
     * Finds the DocObiettivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdDocObiettivo Id 
     * @return DocObiettivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdDocObiettivo)
    {
        if (($model = DocObiettivo::findOne($IdDocObiettivo)) !== null) {
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
