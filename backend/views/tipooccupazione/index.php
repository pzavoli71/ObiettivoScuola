<?php

use app\models\TipoOccupazione;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TipoOccupazioneSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tipo Occupaziones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-occupazione-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tipo Occupazione', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'TpOccup',
            'DsOccup',
            'ultagg',
            'utente',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TipoOccupazione $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'TpOccup' => $model->TpOccup]);
                 }
            ],
        ],
    ]); ?>


</div>
