<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Docobiettivo $model */

$this->title = $model->IdDocObiettivo;
$this->params['breadcrumbs'][] = ['label' => 'Docobiettivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="docobiettivo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdDocObiettivo' => $model->IdDocObiettivo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdDocObiettivo' => $model->IdDocObiettivo], [
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
            'IdDocObiettivo',
            'DtDoc',
            'PathDoc',
            'NotaDoc',
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
