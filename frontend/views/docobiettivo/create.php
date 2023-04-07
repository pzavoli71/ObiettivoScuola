<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Docobiettivo $model */

$this->title = 'Create Docobiettivo';
$this->params['breadcrumbs'][] = ['label' => 'Docobiettivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docobiettivo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
