<?php
namespace frontend\controllers\mappe;
use frontend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * Description of MappeController
 *
 * @author Paride
 */
class MappeController  extends BaseController{
        public $layout = "main";
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
    public function actionMappe() {
        return $this->render("mappa");                
    }
}
