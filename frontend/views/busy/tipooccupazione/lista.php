
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
        creaLista($this, $dataProvider, $searchModel);
        $hrefpage = "";
    }
    else {
        $rigapos = 1;
        $models = $dataProvider->getModels();
        $model = $models[0];
		
    }    
?>

<script language="javascript">
    setTimeout(function() {AppGlob.resize2(window);},300);
</script>
    <?php $this->registerJs(
    "AppGlob.registraFunzioniPerListe(apriMenu, apriRigaRelazioni);AppGlob.inizializzaLista();	",
    View::POS_READY,
    'resize-page-script'
    );?>
	
<?php function creaLista($thisobj, $dataProvider, $searchModel) {?>

<script type="text/javascript">
// Apre una riga sotto quella corrente, per visualizzare le relazioni aperte con altri pdc
function apriRigaRelazioni(chiave, nomepdc, riga, rigarel) {
    // La riga corrispondente all'elemento selezionato e' la seguente
	var spezzanome = nomepdc.split('.');
	var nome = spezzanome[spezzanome.length - 1];                   
	var tr = riga; 
	var chiavi = chiave.split('_'); 
        var dati = {};
	if ( nome == 'TipoOccupazione') {
		dati['TpOccup'] = chiavi[0];

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
	if ( nome == 'TipoOccupazione') {
		dati['TpOccup'] = chiavi[0];

	}
	<?php $currentcontroller = Yii::$app->controller->id; ?>
	
	AppGlob.reloadRelazione('<?= Url::toRoute($currentcontroller . "/reloadrelazione")?>',nomepdc,nomerelazione,dati,odivRelaz, function(dati, data) {
		AppGlob.inizializzaLista();
    });
}

function apriForm(obj, href, callback) {
	if (this.formids == null) {
		this.formids = 0;
	}
	this.formids++;
	var dati = {};
	var s = "<div class='ui-dialog form-container' id='form_" + formids + "'>";
	s += "<iframe class='frame-form'></iframe>";
	s += "</div>";
	// Cerco tab-container
	$container = Tabs.findContainer(obj);
	if ($container == null)
		$('body').append(s);
	else
		$container.append(s);
	$form = $('#form_'+formids);
	$form[0].atag = obj;
	if ( href == '' || href == 'undefined' || href == null) {
		href = $(obj).attr('href');
	}	
	$form.dialog({
		appendTo: $container,
		autoOpen: true,
		modal:false,
		title:'Inserisci i parametri',
        position:{ my: 'top', at: 'top+150', of: window.top },
		width: 500,
		show: {
        	effect: "blind",
        	duration: 100
      	},
      	hide: {
        	effect: "explode",
        	duration: 400
      	},
		open: function() {
			$form.find('iframe.frame-form').attr('src',href);
		},
		beforeClose: function() {
			if ( callback && callback !== 'undefined') {
                            if ( typeof callback === 'string') {
                                eval(callback);
                            } else if ( typeof callback === 'function' )
                                callback();
                        }
			$(this).dialog( "destroy" );		
			$(this).remove();
		}
     });
	 return false;
}

function richiestaComando(nomecomando, chiave, dati) {
	// Qui posso variare il contenuto dell'area dati, aggiungendo attributi con nome e valore
	// che verranno riportati alla servlet come parametri.
	var valore = prompt('inserisci il comando per ',chiave);
	dati.Cognome='xxxxx';
	return true;
}

// Funzione che gestisce il ritorno del comando
function comandoTerminato(nomecomando, chiave, data, href, callback) {
	var errore = $('DOCUMENTO > ERRORE > USER', data).text();
	AppGlob.emettiErrore(errore);
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

    <h1><?= Html::encode($thisobj->title) ?></h1>
    
    <!-- Maschera per la ricerca -->
    <!--?= $thisobj->render('_search', [
		'model' => $searchModel,
    ]) ?-->

    <p>
		<?php echo frontend\controllers\SiteController::linkwin('Aggiungi|fa-plus', 'busy/tipooccupazione/create', [], 'Inserisci un nuovo elemento'); ?>
		<!--a class="btn btn-success" onclick="apriForm(this, '/index.php?r=quiz/create')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-plus" aria-hidden="true"></span>Create TipoOccupazione</a-->	
    </p>

    <?= Yii::$app->session->getFlash('kv-detail-success'); ?>

    <?php
		$models = $dataProvider->getModels();?>
		<table class="tabLista kv-grid-table table table-bordered table-striped kv-table-wrap"> 
		<tr >
			<th style="min-width:180px"></th>
			<th data-nomecol='TpOccup'>TpOccup</th>
			<th data-nomecol='DsOccup'>DsOccup</th>

		</tr>

		<?php
		
		$pos = 1;
		foreach ($models as $riga) {?>
			<tr id='RigaTipoOccupazione_<?=$pos?>' chiave="<?=$riga->TpOccup?>">
				<td><?= showToggleInrelations($riga,$pos,true) ?>
					<?php echo frontend\controllers\SiteController::linkwin('Edit|fa-edit', 'busy/tipooccupazione/update', ['TpOccup'=>$riga->TpOccup], 'Apri per modifica','document.location.reload(false)'); ?>
					<!--a onclick="apriForm(this, '/index.php?r=quiz/update&TpOccup=<?=$riga->TpOccup?>', 'document.location.reload(false)')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-pencil-alt" aria-hidden="true"></span></a-->				
				</td>   
				<td><?= $riga->TpOccup ?></td>
				<td><?= $riga->DsOccup ?></td>
		
			</tr>
			<?= RelazioniTipoOccupazione($riga,$pos) ?>                         
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
function RelazioniTipoOccupazione($riga, $rigapos) { ?>

<!-- ============================================ -->
<!--    Relazioni tra i pdc                       -->
<!-- ============================================ -->
	<tr id="RigaRelTipoOccupazione_<?=$rigapos?>" class="<?=fmod($rigapos,2) == 1?'rigaDispari':'rigapari'; ?>">
    <td colspan="100" class="closed tdRelazione" >
		
    <div style="margin-left:20px;" id="divRel_TipoOccupazione_Obiettivo_<?=$rigapos?>" class="divRelazione" chiave="<?=$riga->TpOccup?>" nomepdc="busy\TipoOccupazione" nomerelaz="TipoOccupazione_Obiettivo">
		<div class="titolorelaz"><a class="refresh_btn cis-button btn_riga" href="javascript:void(0)" onclick="caricaRelazione(this)">
			<i class="fa fa-sync"></i>
		</a>
		<?php echo frontend\controllers\SiteController::linkwin('Aggiungi un Obiettivo|fa-plus', 'busy/obiettivo/create', [], 'Apri per inserimento','caricaRelazione(this.atag)'); ?>
		&#xA0;
		<span class="titolo1">Relazione Obiettivo</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<?php RelazioneTipoOccupazione_Obiettivo($riga,$rigapos) ?>
		</div>
		

    </td>
	</tr>
<?php } ?>


		
<?php 
function RelazioneTipoOccupazione_Obiettivo($riga, $rigapos) { ?>
	<div class="divLista">
	<!--xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template> -->
	<table border="0" cellpadding="2" cellspacing="0" class="tabLista" id="tabListaTipoOccupazione_Obiettivo_<?=$rigapos?>" nomepdc="TipoOccupazione">
		<?= IntestaTabellaObiettivo()?>
		<?php foreach ($riga->obiettivo as $value) {
			RecordObiettivo($value,$rigapos);
		}?>		
	</table>
	</div>
<?php } ?>	
		

<?php 
function IntestaTabellaObiettivo() { ?>
<tr>
<th style="min-width:180px"></th>

     <th data-nomecol="IdObiettivo" >IdObiettivo</th>

     <th data-nomecol="DtInizioObiettivo" >DtInizioObiettivo</th>

     <th data-nomecol="DescObiettivo" >DescObiettivo</th>

     <th data-nomecol="DtScadenzaObiettivo" >DtScadenzaObiettivo</th>

     <th data-nomecol="MinPrevisti" >MinPrevisti</th>

     <th data-nomecol="DtFineObiettivo" >DtFineObiettivo</th>

     <th data-nomecol="NotaObiettivo" >NotaObiettivo</th>

     <th data-nomecol="PercCompletamento" >PercCompletamento</th>

     <th data-nomecol="IdSoggetto" >IdSoggetto</th>

     <th data-nomecol="TpOccup" >TpOccup</th>

</tr>
<?php } ?>	


<!-- ============================================ -->
<!--    Righe tabella                             -->
<!-- ============================================ -->
<?php 
function RecordObiettivo($rigarel, $pos) { ?>

   <tr id='RigaObiettivo_<?=$pos?>' chiave='<?=$rigarel->IdObiettivo?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\SiteController::linkwin('Edit|fa-edit', 'busy/obiettivo/update', ['IdObiettivo'=>$rigarel->IdObiettivo], 'Apri per modifica','caricaRelazione(this.atag)'); ?>
		</td>

		<td><?=$rigarel->IdObiettivo?></td>

		<td><?=$rigarel->DtInizioObiettivo?></td>

		<td><?=$rigarel->DescObiettivo?></td>

		<td><?=$rigarel->DtScadenzaObiettivo?></td>

		<td><?=$rigarel->MinPrevisti?></td>

		<td><?=$rigarel->DtFineObiettivo?></td>

		<td><?=$rigarel->NotaObiettivo?></td>

		<td><?=$rigarel->PercCompletamento?></td>

		<td><?=$rigarel->IdSoggetto?><?=$rigarel->soggetto->NomeSoggetto ?></td>

		<td><?=$rigarel->TpOccup?></td>

		</tr >

	<!--xsl:call-template name="RelazioniObiettivo"/-->
<?php } ?>	
