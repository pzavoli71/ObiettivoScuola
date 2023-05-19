
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\View;

$this->title = 'Titolo della pagina';
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
				
        if ($nomerelaz == "Argomento_TipoOccupazione") {
            RelazioneArgomento_TipoOccupazione($model, $rigapos, true);
		}				
				
        if ($nomerelaz == "Argomento_PermessoArg") {
            RelazioneArgomento_PermessoArg($model, $rigapos, true);
		}
		
		resizeAll();
    }    
?>

<?php function resizeAll() {?>
<script language="javascript" id="scripttimeout">
    setTimeout(function() {AppGlob.resize2(window); $('#scripttimeout').remove();},300);
</script>
<?php }?>

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
	if ( nome == 'busy\\Argomento') {
		dati['IdArg'] = chiavi[0];

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
	if ( nome == 'busy\\Argomento') {
		dati['IdArg'] = chiavi[0];

	}
	<?php $currentcontroller = Yii::$app->controller->id; ?>
	
	AppGlob.reloadRelazione('<?= Url::toRoute($currentcontroller . "/reloadrelazione")?>',nomepdc,nomerelazione,dati,odivRelaz, function(dati, data) {
		AppGlob.inizializzaLista();
    });
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
                                debugger;
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

function richiestaComando(nomecomando, chiave, dati) {
	// Qui posso variare il contenuto dell'area dati, aggiungendo attributi con nome e valore
	// che verranno riportati alla servlet come parametri.
	var valore = prompt('inserisci il comando per ',chiave);
	//if ( nomecomando == 'busy/obiettivo/chiudilavoro') {
	//	dati.IdLavoro = chiave;
	//}	
	dati.Cognome='xxxxx';
	return true;
}

// Funzione che gestisce il ritorno del comando
function comandoTerminato(nomecomando, chiave, data, href, callback) {
	function terminaComando() {
		if ( nomecomando == 'busy/obiettivo/chiudilavoro') {
			var id = nomecomando.replace(/\//g,'_');
			id += '_' + chiave;                    
			$a = $('#' + id);
			//caricaRelazione($a);
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
    
	<!-- Dialog per richiesta parametri, normalmente invisibile -->
	<div id="dialog" class="dialogcomando">
        <div class="cis-field-container" id="CampoNoteCompl">
            <label style="">Aggiungi una nota</label>
            <div class="ValoreAttributo" style=""><textarea name="NoteCompl" class="cis-input-textarea" origvalue="seconda prova, spero che vada a buon fine" cols="30" rows="4" id="NoteCompl" title="" placeholder="inserisci una nota..."></textarea>
            </div>
        </div>					
    </div>
	
    <h4><?= Html::encode($thisobj->title) ?></h4>
    
    <!-- Maschera per la ricerca -->
    <!--?= $thisobj->render('_search', [
		'model' => $searchModel,
    ]) ?-->

    <p style="margin-bottom:0px; margin-top:5px">
		<?php echo frontend\controllers\BaseController::linkwin('Aggiungi|fa-plus', 'busy/argomento/create', [], 'Inserisci un nuovo elemento','document.location.reload(false)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
		<!--a class="btn btn-success" onclick="apriForm(this, '/index.php?r=quiz/create')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-plus" aria-hidden="true"></span>Create Argomento</a-->	
    </p>

    <?= Yii::$app->session->getFlash('kv-detail-success'); ?>

    <?php
		$models = $dataProvider->getModels();?>
		<table class="tabLista kv-grid-table table table-bordered table-striped kv-table-wrap"> 
		<tr >
			<th style="min-width:180px"></th>
			<th data-nomecol='IdArg'>IdArg</th>
			<th data-nomecol='DsArgomento'>DsArgomento</th>
			<th data-nomecol='IdArgPadre'>IdArgPadre</th>

		</tr>
		<!--td> Per i comandi sulla riga
		</td-->

		<?php
		
		$pos = 1;
		foreach ($models as $riga) {?>
			<tr id='RigaArgomento_<?=$pos?>' chiave="<?=$riga->IdArg?>" class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
				<td><?= showToggleInrelations($riga,$pos,true) ?>
					<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'busy/argomento/view', ['IdArg'=>$riga->IdArg], 'Apri per modifica','document.location.reload(false)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
				</td>   
				<td><span class="headcol">IdArg:</span><?= $riga->IdArg ?></td>
				<td><span class="headcol">DsArgomento:</span><?= $riga->DsArgomento ?></td>
				<td><span class="headcol">IdArgPadre:</span><?= $riga->IdArgPadre ?></td>
		
			<!--td-->
				<!-- Scommentare per richiamare un comando sulla riga -->
				<!--?php echo frontend\controllers\BaseController::linkcomando('Chiudi|fa-flag-checkered', 'busy/obiettivo/chiudilavoro',$rigarel->IdLavoro, ['IdLavoro'=>$rigarel->IdLavoro], 
						'Esegui il comando'); ?-->                             
				<!--?php echo frontend\controllers\BaseController::linkcomandocondialog('Chiudi|fa-flag-checkered', 'busy/obiettivo/chiudilavoro',$rigarel->IdLavoro, ['IdLavoro'=>$rigarel->IdLavoro], 
						'Apri per modifica'); ?-->                                        						
			<!--/td-->

			</tr>
			<?= RelazioniArgomento($riga,$pos) ?>                         
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
<?php }?>	<!-- function lista() -->
	
	
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
function RelazioniArgomento($riga, $rigapos) { ?>

<!-- ============================================ -->
<!--    Relazioni tra i pdc                       -->
<!-- ============================================ -->
	<tr id="RigaRelArgomento_<?=$rigapos?>" class="<?=fmod($rigapos,2) == 1?'rigaDispari':'rigapari'; ?>">
    <td colspan="100" class="closed tdRelazione" >
		
    <div style="margin-left:20px;" id="divRel_Argomento_TipoOccupazione_<?=$rigapos?>" class="divRelazione" chiave="<?=$riga->IdArg?>" nomepdc="busy\Argomento" nomerelaz="Argomento_TipoOccupazione">
		<div class="titolorelaz"><a class="refresh_btn cis-button btn_riga" href="javascript:void(0)" onclick="caricaRelazione(this)">
			<i class="fa fa-sync"></i>
		</a>
		<?php echo frontend\controllers\BaseController::linkwin('Aggiungi un TipoOccupazione|fa-plus', 'busy/tipooccupazione/create', ['IdArg'=>$riga->IdArg], 'Apri per inserimento','caricaRelazione(this.atag)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
		&#xA0;
		<span class="titolo1">Relazione TipoOccupazione</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<?php RelazioneArgomento_TipoOccupazione($riga,$rigapos) ?>
		</div>
				
    <div style="margin-left:20px;" id="divRel_Argomento_PermessoArg_<?=$rigapos?>" class="divRelazione" chiave="<?=$riga->IdArg?>" nomepdc="busy\Argomento" nomerelaz="Argomento_PermessoArg">
		<div class="titolorelaz"><a class="refresh_btn cis-button btn_riga" href="javascript:void(0)" onclick="caricaRelazione(this)">
			<i class="fa fa-sync"></i>
		</a>
		<?php echo frontend\controllers\BaseController::linkwin('Aggiungi un PermessoArg|fa-plus', 'busy/permessoarg/create', ['IdArg'=>$riga->IdArg], 'Apri per inserimento','caricaRelazione(this.atag)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
		&#xA0;
		<span class="titolo1">Relazione PermessoArg</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<?php RelazioneArgomento_PermessoArg($riga,$rigapos) ?>
		</div>
		

    </td>
	</tr>
<?php } ?>


		
<?php 
function RelazioneArgomento_TipoOccupazione($riga, $rigapos, $loadable = false) { ?>
	<div class="divLista">
	<!--xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template> -->
	<table border="0" cellpadding="2" cellspacing="0" class="tabLista" id="tabListaArgomento_TipoOccupazione_<?=$rigapos?>" nomepdc="Argomento">
		<?= IntestaTabellaTipoOccupazione()?>
		<?php if ( $loadable)
			foreach ($riga->tipooccupazione as $value) {
			RecordTipoOccupazione($value,$rigapos);
		}?>		
	</table>
	</div>
<?php } ?>	
		
<?php 
function RelazioneArgomento_PermessoArg($riga, $rigapos, $loadable = false) { ?>
	<div class="divLista">
	<!--xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template> -->
	<table border="0" cellpadding="2" cellspacing="0" class="tabLista" id="tabListaArgomento_PermessoArg_<?=$rigapos?>" nomepdc="Argomento">
		<?= IntestaTabellaPermessoArg()?>
		<?php if ( $loadable)
			foreach ($riga->permessoarg as $value) {
			RecordPermessoArg($value,$rigapos);
		}?>		
	</table>
	</div>
<?php } ?>	
		

<?php 
function IntestaTabellaTipoOccupazione() { ?>
<tr>
<th style="min-width:180px"></th>

     <th data-nomecol="TpOccup" >TpOccup</th>

     <th data-nomecol="DsOccup" >DsOccup</th>

     <th data-nomecol="IdArg" >IdArg</th>

</tr>
<?php } ?>	


<!-- ============================================ -->
<!--    Righe tabella                             -->
<!-- ============================================ -->
<?php 
function RecordTipoOccupazione($rigarel, $pos) { ?>

   <tr id='RigaTipoOccupazione_<?=$pos?>' chiave='<?=$rigarel->TpOccup?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'busy/tipooccupazione/view', ['TpOccup'=>$rigarel->TpOccup], 'Apri per modifica','caricaRelazione(this.atag)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
		</td>

		<td><span class="headcol">TpOccup:</span><?=$rigarel->TpOccup?></td>

		<td><span class="headcol">DsOccup:</span><?=$rigarel->DsOccup?></td>

		<td><span class="headcol">IdArg:</span><?=$rigarel->IdArg?><?=$rigarel->argomento->DsArgomento?></td>

		<!--td-->
		
		<!--/td-->
		</tr >

	<!--xsl:call-template name="RelazioniTipoOccupazione"/-->
<?php } ?>	
		

<?php 
function IntestaTabellaPermessoArg() { ?>
<tr>
<th style="min-width:180px"></th>

     <th data-nomecol="IdPermessoArg" >IdPermessoArg</th>

     <th data-nomecol="IdSoggetto" >IdSoggetto</th>

     <th data-nomecol="IdArg" >IdArg</th>

     <th data-nomecol="TpPermesso" >TpPermesso</th>

</tr>
<?php } ?>	


<!-- ============================================ -->
<!--    Righe tabella                             -->
<!-- ============================================ -->
<?php 
function RecordPermessoArg($rigarel, $pos) { ?>

   <tr id='RigaPermessoArg_<?=$pos?>' chiave='<?=$rigarel->IdPermessoArg?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'busy/permessoarg/view', ['IdPermessoArg'=>$rigarel->IdPermessoArg], 'Apri per modifica','caricaRelazione(this.atag)',['windowtitle'=>'Inserisci i parametri','windowwidth'=>'700']); ?>
		</td>

		<td><span class="headcol">IdPermessoArg:</span><?=$rigarel->IdPermessoArg?></td>

		<td><span class="headcol">IdSoggetto:</span><?=$rigarel->IdSoggetto?><?=$rigarel->soggetto->NomeSoggetto ?></td>

		<td><span class="headcol">IdArg:</span><?=$rigarel->IdArg?><?=$rigarel->argomento->DsArgomento ?></td>

		<td><span class="headcol">TpPermesso:</span><?=$rigarel->TpPermesso?><?=$rigarel->tipopermesso->DsPermesso?></td>

		<!--td-->
		
		<!--/td-->
		</tr >

	<!--xsl:call-template name="RelazioniPermessoArg"/-->
<?php } ?>	

