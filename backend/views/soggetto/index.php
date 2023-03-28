<?php

use common\models\Soggetto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Soggettos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="soggetto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Soggetto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'IdSoggetto',
            'NomeSoggetto',
            'EmailSogg:email',
            'bRagazzo',
            'CodISS',
            //'id',
            //'ultagg',
            //'utente',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Soggetto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'IdSoggetto' => $model->IdSoggetto]);
                 }
            ],
        ],
    ]); ?>


</div>
