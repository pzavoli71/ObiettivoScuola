<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Docobiettivo $model */

$this->title = 'Update Docobiettivo: ' . $model->IdDocObiettivo;
$this->params['breadcrumbs'][] = ['label' => 'Docobiettivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdDocObiettivo, 'url' => ['view', 'IdDocObiettivo' => $model->IdDocObiettivo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="docobiettivo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
