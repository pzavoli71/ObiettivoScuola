<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TipoOccupazione $model */

$this->title = $model->TpOccup;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Occupaziones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipo-occupazione-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'TpOccup' => $model->TpOccup], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'TpOccup' => $model->TpOccup], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'TpOccup',
            'DsOccup',
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
