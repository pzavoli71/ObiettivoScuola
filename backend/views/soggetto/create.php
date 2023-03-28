<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Soggetto $model */

$this->title = 'Create Soggetto';
$this->params['breadcrumbs'][] = ['label' => 'Soggettos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="soggetto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
