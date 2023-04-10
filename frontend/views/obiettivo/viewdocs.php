<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/** @var yii\web\View $this */
/** @var common\models\Obiettivo $model */

$this->title = $model->IdObiettivo;
\yii\web\YiiAsset::register($this);
?>
<div class="obiettivo-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php    foreach ($model->docobiettivos as $docobiettivo) { ?>
    <p>
        <?= Html::a('Update', ['docobiettivo/update',  'IdDocObiettivo' => $docobiettivo->IdDocObiettivo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['docobiettivo/delete', 'IdDocObiettivo' => $docobiettivo->IdDocObiettivo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php if (isSet($docobiettivo->PathDoc)) {?>
    <div class="summary">
        <b><?=$docobiettivo->DtDoc ?></b><br/>
        <?=$docobiettivo->NotaDoc ?>
    </div>
        <audio controls style="display:inline-block">
            <source src="<?=Url::to('@web/uploads/' . $docobiettivo->PathDoc)?>" type="audio/ogg">
            Your browser does not support the audio element.
        </audio>
    
        <!--?= Html::a('Ascolta',Url::to('@web/uploads/' . $docobiettivo->PathDoc),['target'=>'_blank']);?-->
    <?php } ?>
    <!--?= DetailView::widget([
        'model' => $docobiettivo,
        'attributes' => [
            'DtDoc',
            'PathDoc',
            'ultagg',
            'utente',
            
        ],
    ]) ?-->
    <?php } ?>
</div>
