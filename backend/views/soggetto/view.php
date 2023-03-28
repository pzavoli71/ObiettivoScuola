<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Soggetto $model */

$this->title = $model->IdSoggetto;
$this->params['breadcrumbs'][] = ['label' => 'Soggettos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="soggetto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdSoggetto' => $model->IdSoggetto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdSoggetto' => $model->IdSoggetto], [
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
            'IdSoggetto',
            'NomeSoggetto',
            'EmailSogg:email',
            'bRagazzo',
            'CodISS',
            'id',
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
