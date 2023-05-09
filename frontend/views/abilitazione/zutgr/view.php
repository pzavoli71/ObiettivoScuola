
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\abilitazione\zUtGr $model */

$this->title = $model->idutgr;

\yii\web\YiiAsset::register($this);
?>
<div class="zutgr-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idutgr'=>$model->idutgr], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idutgr'=>$model->idutgr], [
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
		
			['label'=>'gruppo','value'=>$model->zgruppo->nomegruppo],
		
			['label'=>'Utente','value'=>$model->user->soggetto->NomeSoggetto],
		
            'utente',
            'ultagg',
        ],
    ]) ?>

</div>
