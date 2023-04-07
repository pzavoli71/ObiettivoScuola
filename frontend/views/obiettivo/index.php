<?php

use common\models\Obiettivo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
//use yii\grid\GridView;
use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;
/** @var yii\web\View $this */
/** @var common\models\ObiettivoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Obiettivos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obiettivo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Obiettivo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                    if (count($model->docobiettivos) > 0) {        
                        return GridView::ROW_EXPANDED;
                    } else {
                        return GridView::ROW_COLLAPSED;
                    }
                },
                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('viewdocs', ['model' => $model]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'expandOneOnly' => true],
            'IdObiettivo',
            'IdSoggetto',
            'TpOccup',
            'DtInizioObiettivo',
            'DescObiettivo',
            ['attribute'=>'Docobiettivo',
                'format'=>'raw',
             'value'=>function($model) {
                        if ( isset($model->soggetto)) {
                            return Html::a($model->soggetto->NomeSoggetto, ['soggetto/update','IdSoggetto' => $model->soggetto->IdSoggetto], [ 'class' => 'btn btn-success btn-xs', 'data-pjax' => 0,'title'=>'Apri per modificare il profilo']);                            
                        }
                    }
            ],            
            //'DtScadenzaObiettivo',
            //'MinPrevisti',
            //'DtFineObiettivo',
            //'NotaObiettivo',
            //'PercCompletamento',
            //'ultagg',
            //'utente',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Obiettivo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'IdObiettivo' => $model->IdObiettivo]);
                 },
                'template' => '{view} {update} {delete} {documento}',  // the default buttons + your custom button
                'buttons' => [
                    'documento' => function($url, $model, $key) {     // render your custom button
                        return Html::a('Aggiungi documento', ['docobiettivo/create','IdObiettivo' => $model->IdObiettivo], [ 'class' => 'btn btn-success btn-xs', 'data-pjax' => 0]);
                    }
                ]                 
            ],
        ],
    ]); ?>


</div>
