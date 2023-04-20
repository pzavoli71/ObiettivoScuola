
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\patente\DomandaQuiz $model */

$this->title = $model->IdDomandaTest;

\yii\web\YiiAsset::register($this);
?>
<div class="domandaquiz-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdDomandaTest'=>$model->IdDomandaTest], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdDomandaTest'=>$model->IdDomandaTest], [
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
		
			'IdQuiz',
		
			'IdDomanda',
		
			'IdDomandaTest',
		
            'ultagg',
            'utente',
        ],
    ]) ?>

</div>
