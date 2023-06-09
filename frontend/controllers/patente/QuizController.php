<?php

namespace frontend\controllers\patente;

use common\models\patente\Quiz;
use common\models\patente\QuizSearch;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * QuizController implements the CRUD actions for Quiz model.
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

        return $this->render('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
            /*$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (!$model->upload()) {
                // file is uploaded successfully
                return;
            }*/
            if ($model->load($this->request->post())) {
                //$model->PathDoc = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                if ($model->save()) {
                    return $this->redirect(['view', 'IdQuiz'=>$model->IdQuiz]);
                }
            }
        } else {
            //$model->IdObiettivo = $this->request->queryParams['IdObiettivo'];    
            $items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
            $this->addCombo('users', $items);          
            $model->loadDefaultValues();
        }

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
            //$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            //if (isSet($model->imageFile) && !$model->upload()) {
                // file is uploaded successfully
            //    return;
            //}
            if ($model->load($this->request->post())) {
                //if (isSet($model->imageFile))
                //    $model->PathDoc = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                if ($model->save()) {
                    return $this->redirect(['view', 'IdQuiz'=>$model->IdQuiz]);
                }
            }
        }
        //$model->IdObiettivo = $this->request->queryParams['IdObiettivo'];    
        $items = ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username');
        $this->addCombo('users', $items);          
        

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
        $this->findModel($IdQuiz)->delete();

        return $this->redirect(['index']);
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
        if (($model = Quiz::findOne(['IdQuiz'=>$IdQuiz])) !== null) {
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
    public function actionReloadrelazione($nomepdc, $nomerelaz, $IdQuiz)
    {
        $searchModel = new QuizSearch();
		if ($nomerelaz == "Quiz_DomandaQuiz" ) 
			$dataProvider = $searchModel->searchDomande($this->request->queryParams, $IdQuiz);
		if ( $nomerelaz == "DomandaQuiz_RispQuiz") {
			//$searchModel = new DomandaQuizSearch();
			$dataProvider = $searchModel->searchRisposte($this->request->queryParams, $IdQuiz);
		}
		if ($nomerelaz != "Quiz_DomandaQuiz" && $nomerelaz != "DomandaQuiz_RispQuiz") 
			return;
			
        return $this->renderPartial('lista', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'IdQuiz' => $IdQuiz,
            'nomepdc' => $nomepdc,
            'nomerelaz' => $nomerelaz,      
			'rigapos' => 1,
        ]);
    }
    
}
