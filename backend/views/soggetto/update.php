<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Soggetto $model */

$this->title = 'Update Soggetto: ' . $model->IdSoggetto;
$this->params['breadcrumbs'][] = ['label' => 'Soggettos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IdSoggetto, 'url' => ['view', 'IdSoggetto' => $model->IdSoggetto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="soggetto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
