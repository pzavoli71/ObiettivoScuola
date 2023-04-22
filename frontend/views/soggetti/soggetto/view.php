
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\soggetti\Soggetto $model */

$this->title = $model->IdSoggetto;

\yii\web\YiiAsset::register($this);
?>
<div class="soggetto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdSoggetto'=>$model->IdSoggetto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdSoggetto'=>$model->IdSoggetto], [
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
		
			'id',
		
			'IdSoggetto',
		
			'NomeSoggetto',
		
			'EmailSogg',
		
			'bRagazzo:boolean',
		
			'CodISS',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
