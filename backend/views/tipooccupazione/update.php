<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoOccupazione $model */

$this->title = 'Update Tipo Occupazione: ' . $model->TpOccup;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Occupaziones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TpOccup, 'url' => ['view', 'TpOccup' => $model->TpOccup]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-occupazione-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
