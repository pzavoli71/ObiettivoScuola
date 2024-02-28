
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;


/** @var yii\web\View $this */
/** @var common\models\busy\DocObiettivo $model */
$this->params['model'] = $model;
$this->title = $model->IdDocObiettivo;

\yii\web\YiiAsset::register($this);
?>
<div class="docobiettivo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'IdDocObiettivo'=>$model->IdDocObiettivo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'IdDocObiettivo'=>$model->IdDocObiettivo], [
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
		
			/*'IdObiettivo',
		
			'IdDocObiettivo',*/
		
			'DtDoc',
		
			'PathDoc',
		
                        ['label'=>'Testo', 'value'=>$model->NotaDoc,'format'=>'html'],
		
            //['label'=>'ultagg','value'=>$model->ultagg,'captionOptions'=>['class'=>'ultagg'],'contentOptions'=>['class'=>'ultagg']],
            //['label'=>'utente','value'=>$model->utente,'captionOptions'=>['class'=>'utente'],'contentOptions'=>['class'=>'utente']],
        ],
    ]) ?>

</div>

<?php Yii::$app->view->on(View::EVENT_END_BODY, function () {
    echo ('<span class="ultagg">Modificato da <b style="">'. $this->params['model']['utente'] . '</b> in data <b>' . $this->params['model']['ultagg'] . '</b></span>');
});
?>