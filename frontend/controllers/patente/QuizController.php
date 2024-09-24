<?php

namespace frontend\controllers\patente;

use common\models\patente\Quiz;
use common\models\patente\QuizSearch;
use yii\web\Controller;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;

use Yii;

/**
 * QuizController implements the CRUD actions for Quiz model.
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('patente/quiz/create' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('patente/quiz/update' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('patente/quiz/delete' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('patente/quiz/view' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	INSERT INTO zTrans (NomeTrans,ultagg,utente) VALUES ('patente/quiz/lista' ,CURRENT_TIMESTAMP,'appl');
	SET @id = (SELECT LAST_INSERT_ID());
	INSERT INTO zPermessi(IdTrans,IdGruppo, Permesso, ultagg, utente) VALUES (@id, 1,'LAGMIRVC',CURRENT_TIMESTAMP,'appl');
	
	
 */
class QuizController extends BaseController
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
        $searchModel = new QuizSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $this->actionCombo();
        
        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'parametri' => (!empty($this->request->queryParams['QuizSearch']) ? $this->request->queryParams['QuizSearch'] : null),
        ]);
    }

    /**
     * Displays a single Quiz model.
     * @param int $IdQuiz Id Doc Obiettivo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdQuiz)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdQuiz),
        ]);
    }

    /**
     * Creates a new Quiz model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Quiz();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $transaction = $model->getDb()->beginTransaction();
                if ( $model->save()) {
                    $transaction->commit();
                    return $this->redirect(['view', 'IdQuiz'=>$model->IdQuiz]);
                } else {
                    $transaction->rollBack();
                    return false;
                }
            }
        } else {
            $model->loadDefaultValues();
            $model->id = \Yii::$app->user->id;            						
            $format = \common\config\db\mysql\ColumnSchema::$saveDateTimeFormat;
            $model->DtCreazioneTest = date($format); // '2024-01-18 13:05:00';
        }
		// Combo da aggiungere alla maschera
        $this->actionCombo();
		// 'id' e 'username' devono essere capitalizzati!!
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Quiz model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdQuiz Id Doc Obiettivo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdQuiz)
    {
        $model = $this->findModel($IdQuiz);

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
                    return $this->redirect(['view', 'IdQuiz'=>$model->IdQuiz]);
                }
            }
        }
		$this->actionCombo($model);
		// Combo da aggiungere alla maschera
		// 'id' e 'username' devono essere capitalizzati!!
		//$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
		//$this->addCombo('users', $items);          

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Quiz model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdQuiz Id 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdQuiz)
    {
        $model = $this->findModel($IdQuiz);
        if ( $model->delete()) {
            Yii::$app->session->setFlash('success', 'Cancellazione effettuata correttamente.Chiudere la maschera.');
            return $this->redirect(['create']);
		}			
        return $this->redirect(['view','IdQuiz'=>$model->IdQuiz]);   
    }

    /**
     * Finds the Quiz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdQuiz Id 
     * @return Quiz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdQuiz)
    {
        if (($model = Quiz::findOne($IdQuiz)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
	 /**
     * Load relazione
     *
     * @return string
     */
    public function actionReloadrelazione($nomepdc, $nomerelaz, $IdQuiz=0, $DaSingle = false)
	{
	    $searchModel = new QuizSearch();
            if ($nomerelaz == "Quiz_DomandaQuiz" ) 
                $dataProvider = $searchModel->searchDomandaquiz($this->request->queryParams, $IdQuiz);
            else if ($nomerelaz == "Quiz_Test" ) 
                $dataProvider = $searchModel->searchTest($this->request->queryParams, $IdQuiz);
            else if ($nomerelaz == "DomandaQuiz_RispQuiz" ) 
                $dataProvider = $searchModel->searchRispQuiz($this->request->queryParams, $IdQuiz);
		
         else {
            return;
        }
		
		if ( $DaSingle) {
            return $this->renderPartial('viewtabs', [
                'model' => $searchModel,
                'dataProvider' => $dataProvider,
				'$IdQuiz' => $IdQuiz,
                'nomepdc' => $nomepdc,
                'nomerelaz' => $nomerelaz,      
				'rigapos' => 1,
            ]);            
        }

        return $this->renderPartial('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            '$IdQuiz' => $IdQuiz,
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

    public function actionCombo($model = null, $nomecombo = null) {
        if (!empty($this->request->queryParams['NomeCombo']))
            $nomecombo = $this->request->queryParams['NomeCombo'];	
        if ( $nomecombo != null) {           
           $activequery = \common\models\busy\TipoOccupazione::find();
            if ($nomecombo === 'IdArg') {
				// Per i combo condizionati, $currvalue è il valore corrente del combo condizionato
                //$activequery->where('IdArg = '.$currvalue);
				// Per i combo dinamici
                $IdSocieta = $this->request->queryParams['IdSocieta'];
                $activequery->where('IdSocieta = '.$IdSocieta);				
            }
            //$items = ArrayHelper::map($activequery->all(),'TpOccup','DsOccup');
            $activequery = \common\models\soggetti\Soggetto::find()->select(['IdSoggetto as id','concat(Cognome, SPACE(1), Nome) as label']);
            $term = $this->request->queryParams['term'];
            if (!empty($term) ) {
                $activequery->andWhere('concat(Cognome, SPACE(1), Nome) like \'%'.$term.'%\'');
            }
            $items = $activequery->orderBy('Cognome, Nome')->asArray()->all();
            return $this->asJson($items);

            /*echo "-";
            foreach($items as $key => $val) {
                echo "<option value='".$key."'";
                if ($key == $currdestvalue) {
                    echo " selected='yes'";
                }
                echo ">".$val."</option>";
            }*/
        } else {
		
			// Mettere al posto di id e username il codice e la descrizione da usare nel combo
			$items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
			$this->addCombo('users', $items);          		
		
         
            /*if ($model != null && !empty($model->IdArg)) {
                $IdArg = $model->IdArg;
                $items = ArrayHelper::map(\common\models\busy\TipoOccupazione::find()->where('IdArg='.$IdArg)->all(), 'TpOccup', 'DsOccup');
                $this->addCombo('TipoOccupazione', $items);          		
            } else {
                $items = ArrayHelper::map(\common\models\busy\TipoOccupazione::find()->all(), 'TpOccup', 'DsOccup');
                $this->addCombo('TipoOccupazione', $items);          		
            }
			$items = ArrayHelper::map(\common\models\soggetti\Squadra::find()->joinWith('societa.progetto.campionato')->where(['campionato.idcampionato'=>$this->request->queryParams['IdCampionato']])->
                                andFilterWhere(['not exists',(new Query())->select('idsquadra')->from('iscrizione')->where('iscrizione.IdCampionato=campionato.idcampionato and iscrizione.IdSquadra=squadra.idsquadra')])->all(), 'IdSquadra', 'NomeSquadra');
			$items = ArrayHelper::map(\common\models\soggetti\Soggetto::find()->select(['IdSoggetto','concat(Cognome, SPACE(1), Nome) as Nome'])->asArray()->all(),'IdSoggetto','Nome');								
			
            */
        }
    }
	
	/* Caricamento di un combo a partire dalla variazione di un altro combo*/
    public function actionReloadcombo($nomecombo, $params = null, $currcombovalue = null) {
        if ( $nomecombo === 'TpOccup') {           
            $activequery = \common\models\busy\TipoOccupazione::find();
            if ( $params !== null) {
                $params = json_decode($params, true);
                foreach($params as $key => $value) {
                    $activequery->where($key . ' = ' . $value);
                }
            }
            $items = ArrayHelper::map($activequery->all(),'TpOccup','DsOccup');
            echo "-";
            foreach($items as $key => $val) {
                echo "<option value='".$key."'";
                if ($key == $currcombovalue) {
                    echo " selected='yes'";
                }
                echo ">".$val."</option>";
            }
        }
    }	
    
    public function actionRispondi() {
        //$idrisp = $this->request->queryParams['IdRispTest'];
        $idrisp = \Yii::$app->request->post('IdRispTest');
        $valore = \Yii::$app->request->post('valore');
        $data = [];
        $data['Risposta'] = 'true';
        $data['IdRispTest'] = $idrisp;
        //$data['error'] = "Tutto bene!";
        if (($risp = \common\models\patente\RispQuiz::findOne($idrisp)) === null) {
            $data['error'] = "Errore in lettura Risposta da modificare!";            
        } else {
            if ( $valore === 'true') {
                $risp->RespVero = -1;
                $risp->RespFalso = 0;
            } else {
                $risp->RespVero = 0;
                $risp->RespFalso = -1;
            }
        }
        if ( !$risp->save()) {
            $data['error'] = "Errore in salvataggio risposta!";            
        }
        return $this->asJson($data);
    }

    public function actionIniziatest() {
        $idquiz = \Yii::$app->request->post('IdQuiz');
        $data = [];
        $data['Risposta'] = 'true';
        //$data['error'] = "Tutto bene!";
        if (($quiz = \common\models\patente\Quiz::findOne($idquiz)) === null) {
            $data['error'] = "Errore in lettura Quiz da iniziare!";            
        } else {
            if ( $quiz->DtInizioTest !== null) {
                $data['error'] = "Il quiz è già in corso. Devi terminarlo.";
                return $this->asJson($data);
            }
            $format = \common\config\db\mysql\ColumnSchema::$saveDateTimeFormat;
            //$convdate = date($format,date_create()); //\DateTime::createFromFormat($format, date_create());
            $quiz->DtInizioTest = date($format); // '2024-01-18 13:05:00';
            $quiz->DtFineTest = null;
            $quiz->EsitoTest = 0;      
            $quiz->bRispSbagliate = 0;
            if ( !$quiz->save()) {
                $data['error'] = "Errore in salvataggio quiz!";            
            }
        }
        return $this->asJson($data);
    }

    public function actionConfermatest() {
        $idquiz = \Yii::$app->request->post('IdQuiz');
        $data = [];
        $data['Risposta'] = 'true';
        
        if (($quiz = \common\models\patente\Quiz::findOne($idquiz)) === null) {
            $data['error'] = "Errore in lettura Quiz da confermare!";            
        } else {
            if ( $quiz->DtInizioTest === null) {
                $data['error'] = "Il quiz non è ancora iniziato.";
                return $this->asJson($data);
            }
            if ( $quiz->DtFineTest !== null) {
                $data['error'] = "Il quiz è già stato terminato. Impossibile terminarlo nuovamente.";
                return $this->asJson($data);
            }
            $transaction = \Yii::$app->db->beginTransaction();
            $sql = "select rq.IdRispTest, rq.IdDomandaTest, d.IdDomanda, d.Valore, RespVero, RespFalso, asserzione from esa_domandaquiz dq INNER JOIN esa_rispquiz rq ";
            $sql .= " on rq.IdDomandaTest = dq.IdDomandaTest INNER JOIN esa_domanda d ON d.IdDomanda = rq.IdDomanda ";
            $sql .= " where dq.IdQuiz = " . $idquiz;	
            $sql .= " and d.bPatenteAB = xx ";
            if ( $quiz->bPatenteAB ) {
                $sql = str_replace('xx','-1',$sql);
            } else {
                $sql = str_replace('xx','0',$sql);
            }
            $Errori = 0;                       
            $query = \Yii::$app->getDb()->createCommand($sql)->queryAll();
            foreach ($query as $riga) {
                $idrisptest = $riga['IdRispTest'];
                $valore = $riga['Valore'];
                $respvero = $riga['RespVero'];
                $respfalso = $riga['RespFalso'];
                $risposta = $riga['asserzione'];
                if ( $respvero == 0 && $respfalso == 0) {
                    $data['error'] = 'La domanda alla risposta ' . $risposta . ' non è stata data.';
                    $transaction->rollBack();
                    return $this->asJson($data);
                }
                // Loggo la risposta che devo aggiornare con l'esito
                if ( ($risp = \common\models\patente\RispQuiz::findOne($idrisptest)) === null) {
                    $data['error'] = 'Non trovo la risposta ' . $risposta;
                    $transaction->rollBack();
                    return $this->asJson($data);
                }
                if (($valore == 0 && $respvero != 0) || ($valore != 0 && $respfalso != 0)) {
                    $risp->EsitoRisp = -1;
                    $risp->bControllata = -1;
                    if ( !$risp->save()) {
                        $transaction->rollBack();
                        $data['error'] = "Errore in salvataggio risposta " . $risposta;            
                        return $this->asJson($data);
                    }
                    $Errori++;
                } else {
                    $risp->EsitoRisp = 0;
                    $risp->bControllata = -1;
                    if ( !$risp->save()) {
                        $data['error'] = "Errore in salvataggio risposta " . $risposta;            
                        $transaction->rollBack();
                        return $this->asJson($data);
                    }
                }                
            }
        
            $format = \common\config\db\mysql\ColumnSchema::$saveDateTimeFormat;
            $quiz->DtFineTest = date($format); //'2024-01-18 13:05:00';
            if ( $Errori > 0) {
                $quiz->EsitoTest = -$Errori;      
            }
            if ( !$quiz->save()) {
                $transaction->rollBack();
                $data['error'] = "Errore in salvataggio quiz!";            
                return $this->asJson($data);
            }
            $transaction->commit();
        }
        return $this->asJson($data);
    }
        
    
    /**
     * Load relazione
     *
     * @return string
     */
    public function actionPrintrelazione($IdQuiz, $SoloSbagliate = 'false', $userid = null, $oscurarisposte = null)
    {
        $searchModel = new QuizSearch();
        $dataProvider = null;
        if ( ! empty($userid) ) {
            $dataProvider = $searchModel->searchDomandaQuizSbagliateUser($this->request->queryParams, $IdQuiz, $userid);
            $content = $this->renderPartial('printquiztutti', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'IdQuiz' => $IdQuiz,
                'rigapos' => 1,
                'SoloSbagliate' => $SoloSbagliate
            ]);
        } else {
            $dataProvider = $searchModel->searchDomandaquiz($this->request->queryParams, $IdQuiz);
            $content = $this->renderPartial('printquiz', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'IdQuiz' => $IdQuiz,
                'rigapos' => 1,
                'SoloSbagliate' => $SoloSbagliate,
                'OscuraRisposte' => $oscurarisposte
            ]);
        }
       
// setup kartik\mpdf\Pdf component
    $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Quiz Patente'],
         // call mPDF methods on the fly
        'methods' => [ 
            'SetHeader'=>['Esito Quiz Patente'], 
            //'SetFooter'=>['{PAGENO}'],
        ]
    ]);
    
    // return the pdf output as per the destination setting
    return $pdf->render();        
    }     
    
}
