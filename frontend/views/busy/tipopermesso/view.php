
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\busy\TipoPermesso $model */

$this->title = $model->TpPermesso;

\yii\web\YiiAsset::register($this);
?>
<div class="tipopermesso-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'TpPermesso'=>$model->TpPermesso], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'TpPermesso'=>$model->TpPermesso], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Insert', ['create'], ['class' => 'btn btn-insert']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
			'TpPermesso',
		
			'DsPermesso',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
