
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\busy\Lavoro $model */

$this->title = $model->IdLavoro;

\yii\web\YiiAsset::register($this);
?>
<div class="lavoro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdLavoro'=>$model->IdLavoro], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdLavoro'=>$model->IdLavoro], [
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
		
			'IdObiettivo',
		
			'IdLavoro',
		
			'DtLavoro',
		
			'OraInizio',
		
			'MinutiInizio',
		
			'NotaLavoro',
		
			'OraFine',
		
			'MinutiFine',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
