<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoOccupazione $model */

$this->title = 'Create Tipo Occupazione';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Occupaziones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-occupazione-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
