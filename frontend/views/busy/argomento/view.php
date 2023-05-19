
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\busy\Argomento $model */

$this->title = $model->IdArg;

\yii\web\YiiAsset::register($this);
?>
<div class="argomento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdArg'=>$model->IdArg], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdArg'=>$model->IdArg], [
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
		
			'IdArg',
		
			'DsArgomento',
		
			'IdArgPadre',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
