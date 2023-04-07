<?php

use common\models\Docobiettivo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\DocobiettivoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Docobiettivos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docobiettivo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Docobiettivo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IdObiettivo',
            'IdDocObiettivo',
            'DtDoc',
            'PathDoc',
            'NotaDoc',
            //'ultagg',
            //'utente',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Docobiettivo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'IdDocObiettivo' => $model->IdDocObiettivo]);
                 }
            ],
        ],
    ]); ?>


</div>
