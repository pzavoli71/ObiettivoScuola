<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Obiettivo $model */

$this->title = 'Create Obiettivo';
$this->params['breadcrumbs'][] = ['label' => 'Obiettivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obiettivo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'items' => $items,
        'itemsTpOccup'=>$itemsTpOccup,        
    ]) ?>

</div>
