<?php

use common\models\Obiettivo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

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

            'IdObiettivo',
            'IdSoggetto',
            'TpOccup',
            'DtInizioObiettivo',
            'DescObiettivo',
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
                 }
            ],
        ],
    ]); ?>


</div>
