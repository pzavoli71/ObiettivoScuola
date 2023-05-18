
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\abilitazione\ztrans $model */

$this->title = $model->idtrans;

\yii\web\YiiAsset::register($this);
?>
<div class="ztrans-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idtrans'=>$model->idtrans], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idtrans'=>$model->idtrans], [
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
		
			'idtrans',
		
			'NomeTrans',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
