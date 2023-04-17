
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\patente\Quiz $model */

$this->title = $model->IdQuiz;

\yii\web\YiiAsset::register($this);
?>
<div class="quiz-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdQuiz'=>$model->IdQuiz], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdQuiz'=>$model->IdQuiz], [
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
		
			'CdUtente',
		
			'IdQuiz',
		
			'DtCreazioneTest',
		
			'DtInizioTest',
		
			'EsitoTest:decimal',
		
			'DtFineTest',
		
			'bRispSbagliate:boolean',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
