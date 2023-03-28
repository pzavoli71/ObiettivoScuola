<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Obiettivo $model */

$this->title = $model->IdObiettivo;
$this->params['breadcrumbs'][] = ['label' => 'Obiettivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="obiettivo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdObiettivo' => $model->IdObiettivo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdObiettivo' => $model->IdObiettivo], [
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
            'IdObiettivo',
            'IdSoggetto',
            'TpOccup',
            'DtInizioObiettivo',
            'DescObiettivo',
            'DtScadenzaObiettivo',
            'MinPrevisti',
            'DtFineObiettivo',
            'NotaObiettivo',
            'PercCompletamento',
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
