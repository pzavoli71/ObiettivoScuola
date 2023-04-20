<?php

namespace frontend\controllers\patente;

use common\models\patente\DomandaQuiz;
use common\models\patente\DomandaquizSearch;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * DomandaquizController implements the CRUD actions for DomandaQuiz model.
	DECLARE @idnodo INT = 0;
	SET @idnodo = (select MAX(idnodo) FROM zTrans) + 1;
	if @idnodo IS NULL
	  BEGIN
	    SET @idnodo = 1
	  END
	print @idnodo
	INSERT INTO zTrans ([CdPDC],[DsPDC],[IdNodo],[IdPadre],[Flag],[ultagg],[utente]) VALUES ('patente/DomandaQuiz/create' ,'patente/DomandaQuiz/create',@idnodo,0,0,GETDATE(),'appl')
	SET @idnodo = (select MAX(idnodo) FROM zTrans) + 1;
	if @idnodo IS NULL
	  BEGIN
	    SET @idnodo = 1
	  END
	print @idnodo
	INSERT INTO zTrans ([CdPDC],[DsPDC],[IdNodo],[IdPadre],[Flag],[ultagg],[utente]) VALUES ('patente/DomandaQuiz/update' ,'patente/DomandaQuiz/update',@idnodo,0,0,GETDATE(),'appl')
	SET @idnodo = (select MAX(idnodo) FROM zTrans) + 1;
	if @idnodo IS NULL
	  BEGIN
	    SET @idnodo = 1
	  END
	print @idnodo
	INSERT INTO zTrans ([CdPDC],[DsPDC],[IdNodo],[IdPadre],[Flag],[ultagg],[utente]) VALUES ('patente/DomandaQuiz/delete' ,'patente/DomandaQuiz/delete',@idnodo,0,0,GETDATE(),'appl')
	SET @idnodo = (select MAX(idnodo) FROM zTrans) + 1;
	if @idnodo IS NULL
	  BEGIN
	    SET @idnodo = 1
	  END
	print @idnodo
	INSERT INTO zTrans ([CdPDC],[DsPDC],[IdNodo],[IdPadre],[Flag],[ultagg],[utente]) VALUES ('patente/DomandaQuiz/view' ,'patente/DomandaQuiz/view',@idnodo,0,0,GETDATE(),'appl')
	SET @idnodo = (select MAX(idnodo) FROM zTrans) + 1;
	if @idnodo IS NULL
	  BEGIN
	    SET @idnodo = 1
	  END
	print @idnodo
	INSERT INTO zTrans ([CdPDC],[DsPDC],[IdNodo],[IdPadre],[Flag],[ultagg],[utente]) VALUES ('patente/DomandaQuiz/index' ,'patente/DomandaQuiz/index',@idnodo,0,0,GETDATE(),'appl')
	

	INSERT INTO zPermessi([CdGruppo],[CdPDC], [Descrizione], [Permesso], [ultagg], [utente]) VALUES (1, 'patente/DomandaQuiz/create',' ','LAGMIRVC',getdate(),'appl')
	INSERT INTO zPermessi([CdGruppo],[CdPDC], [Descrizione], [Permesso], [ultagg], [utente]) VALUES (1, 'patente/DomandaQuiz/update',' ','LAGMIRVC',getdate(),'appl')
	INSERT INTO zPermessi([CdGruppo],[CdPDC], [Descrizione], [Permesso], [ultagg], [utente]) VALUES (1, 'patente/DomandaQuiz/delete',' ','LAGMIRVC',getdate(),'appl')
	INSERT INTO zPermessi([CdGruppo],[CdPDC], [Descrizione], [Permesso], [ultagg], [utente]) VALUES (1, 'patente/DomandaQuiz/view',' ','LAGMIRVC',getdate(),'appl')
	INSERT INTO zPermessi([CdGruppo],[CdPDC], [Descrizione], [Permesso], [ultagg], [utente]) VALUES (1, 'patente/DomandaQuiz/index',' ','LAGMIRVC',getdate(),'appl')
	--INSERT INTO zPermessi([CdGruppo],[CdPDC], [Descrizione], [Permesso], [ultagg], [utente]) VALUES (xxx, 'DomandaQuiz',' ','LAGMIRVC',getdate(),'appl')
 */
class DomandaquizController extends BaseController
{    public $layout = "mainform";
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
        $searchModel = new DomandaquizSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DomandaQuiz model.
     * @param int $IdDomandaTest Id Doc Obiettivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdDomandaTest)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdDomandaTest),
        ]);
    }

    /**
     * Creates a new DomandaQuiz model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DomandaQuiz();

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
                    return $this->redirect(['view', 'IdDomandaTest'=>$model->IdDomandaTest]);
                }
            }
        } else {
			// Mettere qui eventuali valori da assegnare a colonne calcolate
            $model->IdQuiz = $this->request->queryParams['IdQuiz'];            						
            $model->loadDefaultValues();
        }
		// Combo da aggiungere alla maschera
		
		$items = ArrayHelper::map(\common\models\patente\Quiz::find()->all(), 'IdQuiz', 'IdQuiz');
		$this->addCombo('Quiz', $items);          		
		
		$items = ArrayHelper::map(\common\models\patente\Domanda::find()->all(), 'IdDomanda', 'Asserzione');
		$this->addCombo('Domanda', $items);          		
		
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DomandaQuiz model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdDomandaTest Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdDomandaTest)
    {
        $model = $this->findModel($IdDomandaTest);

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
                    return $this->redirect(['view', 'IdDomandaTest'=>$model->IdDomandaTest]);
                }
            }
        }
		
		$items = ArrayHelper::map(\common\models\patente\Domanda::find()->all(), 'IdDomanda', 'Asserzione');
		$this->addCombo('Domanda', $items);          		
		
		// Combo da aggiungere alla maschera
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DomandaQuiz model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdDomandaTest Id 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdDomandaTest)
    {
        $this->findModel($IdDomandaTest)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DomandaQuiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdDomandaTest Id 
     * @return DomandaQuiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdDomandaTest)
    {
        if (($model = DomandaQuiz::findOne(['IdDomandaTest'=>$IdDomandaTest])) !== null) {
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
