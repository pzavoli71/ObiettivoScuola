
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\busy\PermessoArg $model */

$this->title = $model->IdPermessoArg;

\yii\web\YiiAsset::register($this);
?>
<div class="permessoarg-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdPermessoArg'=>$model->IdPermessoArg], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdPermessoArg'=>$model->IdPermessoArg], [
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
		
			'IdSoggetto',
		
			'IdArg',
		
			'TpPermesso',
		
			'IdPermessoArg',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
