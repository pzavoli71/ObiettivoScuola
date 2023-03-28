<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'auth_key',
            ['attribute'=>'password_hash','contentOptions' =>['style'=>'max-width:200px;overflow-x:hidden']],
            'password_reset_token',
            
            
            ['attribute'=>'Soggetto',
                'format'=>'raw',
             'value'=>function($model) {
                        if ( isset($model->soggetto)) {
                            return Html::a($model->soggetto->NomeSoggetto, ['soggetto/update','IdSoggetto' => $model->soggetto->IdSoggetto], [ 'class' => 'btn btn-success btn-xs', 'data-pjax' => 0,'title'=>'Apri per modificare il profilo']);                            
                        }
                    }
            ],
            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'template' => '{view} {update} {delete} {profilo}',  // the default buttons + your custom button
                'buttons' => [
                    'profilo' => function($url, $model, $key) {     // render your custom button
                        return !isset($model->soggetto)?Html::a('Aggiungi dati soggetto', ['soggetto/create','id' => $model->id], [ 'class' => 'btn btn-success btn-xs', 'data-pjax' => 0]):'';
                    }
                ]                 
            ],
        ],
    ]); ?>


</div>
