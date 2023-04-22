
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\busy\TipoOccupazione $model */

$this->title = $model->TpOccup;

\yii\web\YiiAsset::register($this);
?>
<div class="tipooccupazione-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'TpOccup'=>$model->TpOccup], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'TpOccup'=>$model->TpOccup], [
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
		
			'TpOccup',
		
			'DsOccup',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
