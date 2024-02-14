
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\View;

$this->title = 'Stampa obiettivi';
?>

<?php
        $models = $dataProvider->getModels();
        $model = $models[0];
?>

<!-- Inizio form -->
<div class="quiz-index">
    
    <div id="dialog" class="dialogcomando">
        <div class="cis-field-container" id="CampoNoteCompl">
            <label style="">Aggiungi una nota</label>
            <div class="ValoreAttributo" style=""><textarea name="NoteCompl" class="cis-input-textarea" origvalue="seconda prova, spero che vada a buon fine" cols="30" rows="4" id="NoteCompl" title="" placeholder="inserisci una nota..."></textarea>
            </div>
        </div>					
    </div>

    <h4><?= Html::encode($this->title) ?></h4>
    <p style="margin-bottom:0px; margin-top:5px">
    <?php echo frontend\controllers\BaseController::linkwin('Aggiungi|fa-plus', 'busy/obiettivo/create', ['IdArg'=>$searchModel->IdArg], 'Inserisci un nuovo elemento','document.location.reload(false)',['windowtitle'=>'Inserisci l\'obiettivo','windowwidth'=>'700']); ?>
    <!--a class="btn btn-success" onclick="apriForm(this, '/index.php?r=quiz/create')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-plus" aria-hidden="true"></span>Create Obiettivo</a-->	
    </p>
    <?= Yii::$app->session->getFlash('kv-detail-success'); ?>

    <?php
		$models = $dataProvider->getModels();?>	
		<?php
		
		foreach ($models as $riga) {?>
<span class="headcol">Soggetto:</span><b> <?=$riga->soggetto->NomeSoggetto ?></b>
<span class="headcol">Materia:</span><?=$riga->tipooccupazione->DsOccup ?>
<span class="headcol">Data inizio:</span><?= $riga->DtInizioObiettivo ?>
		<?php } ?>            
	

