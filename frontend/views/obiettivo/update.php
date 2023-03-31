<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Obiettivo $model */

$this->title = 'Update Obiettivo: ' . $model->IdObiettivo;
$this->params['breadcrumbs'][] = ['label' => 'Obiettivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdObiettivo, 'url' => ['view', 'IdObiettivo' => $model->IdObiettivo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="obiettivo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'itemsTpOccup'=>$itemsTpOccup,        
    ]) ?>

</div>
