<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Obiettivo $model */

$this->title = $model->IdObiettivo;
\yii\web\YiiAsset::register($this);
?>
<div class="obiettivo-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php    foreach ($model->docobiettivos as $docobiettivo) { ?>
    <p>
        <?= Html::a('Update', ['docobiettivo/update',  'IdDocObiettivo' => $docobiettivo->IdDocObiettivo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['docobiettivo/delete', 'IdDocObiettivo' => $docobiettivo->IdDocObiettivo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $docobiettivo,
        'attributes' => [
            'DtDoc',
            'PathDoc',
            'ultagg',
            'utente',
            
        ],
    ]) ?>
    <?php } ?>
</div>
