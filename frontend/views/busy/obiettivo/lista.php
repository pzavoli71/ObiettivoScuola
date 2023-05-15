
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\View;

$this->title = 'Lista obiettivi';
$this->registerJsFile(
    '@web/js/app.js',
    ['depends' => [\yii\web\JqueryAsset::class, \yii\jui\JuiAsset::class]]
);
$this->registerJs(
    "AppGlob.registraFunzioniPerListe(apriMenu, apriRigaRelazioni);",
    yii\web\View::POS_READY,'my_script_id'
);

//Fix for closing icon (x) not showing up in dialog
$this->registerJs("if ($.fn.button && $.fn.button.noConflict) {
                var bootstrapButton = $.fn.button.noConflict(); 
                $.fn.bootstrapBtn = bootstrapButton;
            }",
            \yii\web\View::POS_READY
);
?>

<?php
    $hrefpage = "";
    if (empty($nomerelaz)) {
        creaLista($this, $dataProvider, $searchModel, $combo);
        $hrefpage = "";
    }
    else {
        $rigapos = 1;
        $models = $dataProvider->getModels();
        $model = $models[0];
        if ($nomerelaz == "Obiettivo_Lavoro") {
            RelazioneObiettivo_Lavoro($model, $rigapos, true);
	}
				
        if ($nomerelaz == "Obiettivo_DocObiettivo") {
            RelazioneObiettivo_DocObiettivo($model, $rigapos, true);
	}	
    }    
?>

<script language="javascript" id="scripttimeout">
    setTimeout(function() {AppGlob.resize2(window); $('#scripttimeout').remove();},300);
</script>

<?php $this->registerJs(
"AppGlob.registraFunzioniPerListe(apriMenu, apriRigaRelazioni);AppGlob.inizializzaLista();	",
View::POS_READY,
'resize-page-script'
);?>
	
<?php function creaLista($thisobj, $dataProvider, $searchModel, $combo) {?>

<script type="text/javascript">
// Apre una riga sotto quella corrente, per visualizzare le relazioni aperte con altri pdc
function apriRigaRelazioni(chiave, nomepdc, riga, rigarel) {
    // La riga corrispondente all'elemento selezionato e' la seguente
	var spezzanome = nomepdc.split('.');
	var nome = spezzanome[spezzanome.length - 1];                   
	var tr = riga; 
	var chiavi = chiave.split('_'); 
	var dati = {};
	if ( nome == 'Obiettivo') {
		dati['IdObiettivo'] = chiavi[0];

	}
	// Scommentare per fare il caricamento manuale ogni volta che si clicca sul + di questa relazione
	riga.next().find('.refresh_btn.btn_riga').click();
}

// Apre il menu contestuale in corrispondenza della riga
function apriMenu(chiave, nomepdc, riga) {

}

var ajaxrequest = null;
// Apre il menu contestuale in corrispondenza della riga
function caricaRelazione(obj) { 
	// Devo andare a ritroso nel dom fino a trovare un div con class="divRelazione"
	var odivRelaz = AppGlob.trovaDivRelazione(obj);
	if ( odivRelaz == null)
		return;

	var nomepdc = odivRelaz.attr("nomepdc");
	var nomerelazione = odivRelaz.attr("nomerelaz");
	var chiave = odivRelaz.attr("chiave");
	var dati = {};
	var spezzanome = nomepdc.split('.');
	var nome = spezzanome[spezzanome.length - 1];           
	var chiavi = chiave.split('_'); 
    
	if(odivRelaz.find('.rowsPerPage')) {
		dati['rpp']=odivRelaz.find('.rowsPerPage').val();
	}
	if(odivRelaz.find('.currPage')) {
		if($(obj).hasClass('nextPage')) {
			dati['page']=parseInt(odivRelaz.find('.currPage').val())+1;
		}
		else if($(obj).hasClass('prevPage')) {
			dati['page']=parseInt(odivRelaz.find('.currPage').val())-1;
		}
		else {
			dati['page']=odivRelaz.find('.currPage').val();
		}
	}
	if ( nome == 'busy\\Obiettivo') {
		dati['IdObiettivo'] = chiavi[0];

	}
	<?php $currentcontroller = Yii::$app->controller->id; ?>
	
	AppGlob.reloadRelazione('<?= Url::toRoute($currentcontroller . "/reloadrelazione")?>',nomepdc,nomerelazione,dati,odivRelaz, function(dati, data) {
		AppGlob.inizializzaLista();
                //AppGlob.cambiaTablesScreens();
    });
}

function richiestaComando(nomecomando, chiave, dati) {
	// Qui posso variare il contenuto dell'area dati, aggiungendo attributi con nome e valore
	// che verranno riportati alla servlet come parametri.
	//var valore = prompt('inserisci il comando per ',chiave);
        if ( nomecomando == 'busy/obiettivo/chiudilavoro') {
            dati.IdLavoro = chiave;
        }
	//dati.Cognome='xxxxx';
	return true;
}

function richiestaComandoConDialog(nomecomando, chiave, dati, href,callback,startcomando) {
	// Qui posso variare il contenuto dell'area dati, aggiungendo attributi con nome e valore
	// che verranno riportati alla servlet come parametri.
	var chiavi = chiave.split('_');
	dati.IdDocumento=chiavi[0];
	$('#dialog').dialog({
		autoOpen: true,
		modal:true,
		title:'Inserisci i parametri e premi ok',
		position:{ my: 'top', at: 'top+150' },
		width:600,
		show: {
        	effect: "blind",
        	duration: 100
      	},
      	hide: {
        	effect: "explode",
        	duration: 400
      	},	
		buttons: {
        	Ok: function() {
				var NoteCompl = $( this ).find('#NoteCompl').val();
				//var anno = $( this ).find('#AnnoCompl').val();
				//var mese = $( this ).find('#MeseCompl').val();
				dati.NotaLavoro = NoteCompl;
                                dati.IdLavoro = chiave;
				//dati.AnnoCompl=anno;
				//dati.MeseCompl=mese;
				startcomando(nomecomando,chiave, dati, callback);
          		$( this ).dialog( "close" );	
        	},
        	Annulla: function() {
          		$( this ).dialog( "close" );
        	}
      	}      	
        });	
	return true;
}

// Funzione che gestisce il ritorno del comando
function comandoTerminato(nomecomando, chiave, data, href, callback) {
        function terminaComando() {
            if ( nomecomando == 'busy/obiettivo/chiudilavoro') {
                var id = nomecomando.replace(/\//g,'_');
                id += '_' + chiave;                    
                $a = $('#' + id);
                caricaRelazione($a);
            }                        
        }
        if ( data && data.error) {
            var errore = data.error;
            AppGlob.emettiErrore(errore, function() {
                terminaComando();
            });
        } else {
            terminaComando();
        }
}
</script>


<style>
.cis-field-container label {
	width:150px;
}
/*.cis-field-container .ValoreAttributo {
	width:350px;
}*/
.screen-s .cis-field-container, .screen-m .cis-field-container {
	display:inline-block;
}	
</style>


<!-- Inizio form -->
<div class="quiz-index">
    
    <div id="dialog" class="dialogcomando">
        <div class="cis-field-container" id="CampoNoteCompl">
            <label style="">Aggiungi una nota</label>
            <div class="ValoreAttributo" style=""><textarea name="NoteCompl" class="cis-input-textarea" origvalue="seconda prova, spero che vada a buon fine" cols="30" rows="4" id="NoteCompl" title="" placeholder="inserisci una nota..."></textarea>
            </div>
        </div>					
    </div>

    <h4><?= Html::encode($thisobj->title) ?></h4>
    
    <!-- Maschera per la ricerca -->
    <?= $thisobj->render('_search', [
        'model' => $searchModel,
        'combo' => $combo,        
    ]) ?>
    <p style="margin-bottom:0px; margin-top:5px">
    <?php echo frontend\controllers\BaseController::linkwin('Aggiungi|fa-plus', 'busy/obiettivo/create', [], 'Inserisci un nuovo elemento','document.location.reload(false)',['windowtitle'=>'Inserisci l\'obiettivo','windowwidth'=>'700']); ?>
    <!--a class="btn btn-success" onclick="apriForm(this, '/index.php?r=quiz/create')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-plus" aria-hidden="true"></span>Create Obiettivo</a-->	
    </p>
    <?= Yii::$app->session->getFlash('kv-detail-success'); ?>

    <?php
		$models = $dataProvider->getModels();?>
		<table class="tabLista kv-grid-table table table-bordered table-striped kv-table-wrap"> 
		<tr class="th">
			<th style="min-width:180px"></th>
			<th data-nomecol='IdSoggetto'>Soggetto</th>
                        <th data-nomecol='TpOccup'>Materia</th>
			<th data-nomecol='DtInizioObiettivo'>Inizio</th>
			<th data-nomecol='DescObiettivo'>Descrizione</th>
			<th data-nomecol='DtScadenzaObiettivo'>Scadenza</th>
			<th data-nomecol='MinPrevisti'>Minuti Previsti</th>
			<th data-nomecol='DtFineObiettivo'>Data fine</th>
			<th data-nomecol='NotaObiettivo'>Nota</th>
			<th data-nomecol='PercCompletamento'>Perc. Completamento</th>

		</tr>

		<?php
		
		$pos = 1;
		foreach ($models as $riga) {?>
			<tr id='RigaObiettivo_<?=$pos?>' chiave="<?=$riga->IdObiettivo?>">
				<td><?= showToggleInrelations($riga,$pos,true) ?>
					<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'busy/obiettivo/view', ['IdObiettivo'=>$riga->IdObiettivo], 'Apri per modifica','document.location.reload(false)'); ?>
				</td>   
                                <td><span class="headcol">Soggetto:</span><b> <?=$riga->soggetto->NomeSoggetto ?></b></td>
				<td><span class="headcol">Materia:</span><?=$riga->tipooccupazione->DsOccup ?></td>
				<td><span class="headcol">Soggetto:</span><?= $riga->DtInizioObiettivo ?></td>
				<td><span class="headcol">Soggetto:</span><?= $riga->DescObiettivo ?></td>
				<td><span class="headcol">Soggetto:</span><?= $riga->DtScadenzaObiettivo ?></td>
				<td><span class="headcol">Soggetto:</span><?= $riga->MinPrevisti ?></td>
				<td><span class="headcol">Soggetto:</span><?= $riga->DtFineObiettivo ?></td>
				<td><span class="headcol">Soggetto:</span><?= $riga->NotaObiettivo ?></td>
				<td><span class="headcol">Soggetto:</span><?= $riga->PercCompletamento ?></td>
			</tr>
			<?= RelazioniObiettivo($riga,$pos) ?>                         
			<?php $pos++;?>
		<?php } ?>            

		</table>

		<!-- Paginatore  -->
		<?php
		echo LinkPager::widget([
			'pagination' => $dataProvider->getPagination(),
			'pageCssClass' => 'page-item',
			'linkOptions' => ['class' => 'page-link'],
            //,'onclick' => 'Tabs.openLinkInCurrentTab(this); return false;'],
		]);	
		?>		
	
</div> <!-- div generale -->
<?php } // function lista()?>
	
	
<?php function showToggleInrelations($model, $pos, $ramochiuso) { ?>
    <a pos="<?=$pos?>" href="javascript:void(0)" style="margin-left:1px; margin-right:5px" onclick="AppGlob.apriRigaRelazioni(this, '<?= str_replace("\\",".",get_class($model))?>')" >
        <i class="far <?php if ($ramochiuso == false) echo('fa-minus-square'); else  echo('fa-plus-square');?>">
        </i>        
    </a>
<?php } ?>

	

<?php 
// ============================================ 
//    Righe Relazione                             
// ============================================ 
function RelazioniObiettivo($riga, $rigapos) { ?>

<!-- ============================================ -->
<!--    Relazioni tra i pdc                       -->
<!-- ============================================ -->
	<tr id="RigaRelObiettivo_<?=$rigapos?>" class="<?=fmod($rigapos,2) == 1?'rigaDispari':'rigapari'; ?>">
    <td colspan="100" class="closed tdRelazione" >
		
    <div style="margin-left:20px;" id="divRel_Obiettivo_Lavoro_<?=$rigapos?>" class="divRelazione" chiave="<?=$riga->IdObiettivo?>" nomepdc="busy\Obiettivo" nomerelaz="Obiettivo_Lavoro">
		<div class="titolorelaz"><a class="refresh_btn cis-button btn_riga" href="javascript:void(0)" onclick="caricaRelazione(this)">
			<i class="fa fa-sync"></i>
		</a>
		<?php echo frontend\controllers\BaseController::linkwin('Aggiungi Lavoro|fa-plus', 'busy/lavoro/create', ['IdObiettivo'=>$riga->IdObiettivo], 'Apri per inserimento','caricaRelazione(this.atag)'); ?>
		&#xA0;
		<span class="titolo1">Relazione Lavoro</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<?php RelazioneObiettivo_Lavoro($riga,$rigapos) ?>
		</div>
				
    <div style="margin-left:20px;" id="divRel_Obiettivo_DocObiettivo_<?=$rigapos?>" class="divRelazione" chiave="<?=$riga->IdObiettivo?>" nomepdc="busy\Obiettivo" nomerelaz="Obiettivo_DocObiettivo">
		<div class="titolorelaz"><a class="refresh_btn cis-button btn_riga" href="javascript:void(0)" onclick="caricaRelazione(this)">
			<i class="fa fa-sync"></i>
		</a>
                <?php echo frontend\controllers\BaseController::linkwin('Aggiungi Documento|fa-plus', 'busy/docobiettivo/create', ['IdObiettivo'=>$riga->IdObiettivo], 'Apri per inserimento','caricaRelazione(this.atag)',['windowtitle'=>'Prova','windowwidth'=>'700']); ?>
		&#xA0;
		<span class="titolo1">Relazione DocObiettivo</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<?php RelazioneObiettivo_DocObiettivo($riga,$rigapos) ?>
		</div>
		

    </td>
	</tr>
<?php } ?>


		
<?php 
function RelazioneObiettivo_Lavoro($riga, $rigapos, $loadable = false) { ?>
	<div class="divLista">
	<!--xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template> -->
	<table border="0" cellpadding="2" cellspacing="0" class="tabLista" id="tabListaObiettivo_Lavoro_<?=$rigapos?>" nomepdc="Obiettivo">
		<?= IntestaTabellaLavoro()?>
		<?php if ( $loadable)
                    foreach ($riga->lavoro as $value) {
			RecordLavoro($value,$rigapos);
		}?>		
	</table>
	</div>
<?php } ?>	
		
<?php 
function RelazioneObiettivo_DocObiettivo($riga, $rigapos, $loadable = false) { ?>
	<div class="divLista">
	<!--xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template> -->
	<table border="0" cellpadding="2" cellspacing="0" class="tabLista" caption="Obiettivi" id="tabListaObiettivo_DocObiettivo_<?=$rigapos?>" nomepdc="Obiettivo">
		<?= IntestaTabellaDocObiettivo()?>
		<?php if ( $loadable) 
                    foreach ($riga->docobiettivo as $value) {
			RecordDocObiettivo($value,$rigapos);
		}?>		
	</table>
	</div>
<?php } ?>	
		

<?php 
function IntestaTabellaLavoro() { ?>
<tr class="th">
<th style="min-width:150px"></th>

     <th data-nomecol="DtLavoro" >Data lavoro</th>

     <th data-nomecol="OraInizio" >Ora Inizio</th>

     <th data-nomecol="MinutiInizio" >Minuti Inizio</th>

     <th data-nomecol="NotaLavoro" >Nota</th>

     <th data-nomecol="OraFine" >Ora Fine</th>

     <th data-nomecol="MinutiFine" >Minuti Fine</th>
    <td></td>

</tr>
<?php } ?>	



<?php 
// ============================================ -->
//    Righe tabella                             -->
// ============================================ -->
function RecordLavoro($rigarel, $pos) { ?>

   <tr id='RigaLavoro_<?=$pos?>' chiave='<?=$rigarel->IdLavoro?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'busy/lavoro/view', ['IdLavoro'=>$rigarel->IdLavoro], 'Apri per modifica','caricaRelazione(this.atag)'); ?>
                        <!--?php echo frontend\controllers\BaseController::linkwin('Elimina|fa-trash-alt', 'busy/lavoro/view', ['IdLavoro'=>$rigarel->IdLavoro], 'Apri per modifica','caricaRelazione(this.atag)','btn btn-danger'); ?-->
		</td>

		<td><span class="headcol">Data lavoro:</span><?=$rigarel->DtLavoro?></td>

		<td><span class="headcol">Ora inizio:</span><?=$rigarel->OraInizio?></td>

		<td><?=$rigarel->MinutiInizio?></td>

		<td><?=$rigarel->NotaLavoro?></td>

		<td><?=$rigarel->OraFine?></td>

		<td><?=$rigarel->MinutiFine?></td>
                <td >
                    <?php echo frontend\controllers\BaseController::linkcomandocondialog('Chiudi|fa-flag-checkered', 'busy/obiettivo/chiudilavoro',$rigarel->IdLavoro, ['IdLavoro'=>$rigarel->IdLavoro], 
                            'Apri per modifica'); ?>                                        
                </td>

		</tr >

	<!--xsl:call-template name="RelazioniLavoro"/-->
<?php } ?>	

		

<?php 
function IntestaTabellaDocObiettivo() { ?>
<tr class="th">
<th  style="min-width:150px"></th>

     <th data-nomecol="DtDoc" style="width:163px" >Data</th>

     <th data-nomecol="NotaDoc" >Nota</th>

</tr>
<?php } ?>	



<?php 
// ============================================ -->
//    Righe tabella                             -->
// ============================================ -->
function RecordDocObiettivo($rigarel, $pos) { ?>

   <tr id='RigaDocObiettivo_<?=$pos?>' chiave='<?=$rigarel->IdDocObiettivo?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'busy/docobiettivo/view', ['IdDocObiettivo'=>$rigarel->IdDocObiettivo], 'Apri per modifica','caricaRelazione(this.atag)'); ?>
		</td>

		<td><span class="headcol">Data documento:</span><?=$rigarel->DtDoc?><br/>
                <?php if (str_contains($rigarel->PathDoc,".pdf") || str_contains($rigarel->PathDoc,".doc")) {
                    echo '<a target="blank" href="uploads/' . $rigarel->PathDoc .'">Scarica documento</a>';
                }
                ?>
                <?php if (str_contains($rigarel->PathDoc,".aac") || str_contains($rigarel->PathDoc,".mp3")) { ?>
                <audio controls style="display:inline-block">
                    <source src="<?=Url::to('@web/uploads/' . $rigarel->PathDoc)?>" type="audio/ogg">
                    Your browser does not support the audio element.
                </audio>                    
                <?php }?>
                </td>

		<td><span class="headcol">Nota:</span><?=$rigarel->NotaDoc?></td>

		</tr >

	<!--xsl:call-template name="RelazioniDocObiettivo"/-->
<?php } ?>	

