
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
				
        if ($nomerelaz == "Quiz_DomandaQuiz") {
            RelazioneQuiz_DomandaQuiz($model, $rigapos);
		}
				
        if ($nomerelaz == "Quiz_Test") {
            ListaRelQuiz_Test($model, $rigapos);
		}
		
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
	if ( nome == 'patente\\Quiz') {
		var IdQuiz = chiavi[0];
	} else if (nome == 'patente\\DomandaQuiz') {
		var IdDomandaTest = chiavi[0];
	} else if (nome == 'patente\\Test') {
		var IdTest = chiavi[0];

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
	if ( nome == 'patente\\Quiz') {
		dati['IdQuiz'] = chiavi[0];
	} else if (nome == 'patente\\DomandaQuiz') {
		dati['IdDomandaTest'] = chiavi[0];
	} else if (nome == 'patente\\Test') {
		dati['IdTest'] = chiavi[0];

	}
    
	<?php $currentcontroller = Yii::$app->controller->id; ?>
	
	AppGlob.reloadRelazione('<?= Url::toRoute($currentcontroller . "/reloadrelazione")?>',nomepdc,nomerelazione,dati,odivRelaz, function(dati, data) {
            AppGlob.inizializzaLista();
    });
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
		<?php echo frontend\controllers\BaseController::linkwin('Aggiungi|fa-plus', 'patente/quiz/create', [], 'Inserisci un nuovo elemento'); ?>
		<!--a class="btn btn-success" onclick="return apriForm(this, '/index.php?r=quiz/create')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-plus" aria-hidden="true"></span>Create Quiz</a-->	
    </p>
    <?= Yii::$app->session->getFlash('kv-detail-success'); ?>

    <?php
		$models = $dataProvider->getModels();?>
		<table class="tabLista kv-grid-table table table-bordered table-striped kv-table-wrap"> 
		<tr >
			<th style="min-width:180px"></th>
			<th data-nomecol='IdQuiz'>IdQuiz</th>
			<th data-nomecol='CdUtente'>CdUtente</th>
			<th data-nomecol='DtCreazioneTest'>DtCreazioneTest</th>
			<th data-nomecol='DtInizioTest'>DtInizioTest</th>
			<th data-nomecol='EsitoTest'>EsitoTest</th>
			<th data-nomecol='DtFineTest'>DtFineTest</th>
			<th data-nomecol='bRispSbagliate'>bRispSbagliate</th>

		</tr>

		<?php
		
		$pos = 1;
		foreach ($models as $riga) {?>
			<tr id='RigaQuiz_<?=$pos?>' chiave="<?=$riga->IdQuiz?>"  class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
				<td><?= showToggleInrelations($riga,$pos,true) ?>
					<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'patente/quiz/update', ['IdQuiz'=>$riga->IdQuiz], 'Apri per modifica'); ?>					
				</td>   
				<td><?= $riga->IdQuiz ?></td>
                                <td><?= $riga->CdUtente?><br></td>
				<td><?= $riga->DtCreazioneTest ?></td>
				<td><?= $riga->DtInizioTest ?></td>
				<td><?= $riga->EsitoTest ?></td>
				<td><?= $riga->DtFineTest ?></td>
				<td><?= $riga->bRispSbagliate != 0?'Sì':'No' ?></td>
		
			</tr>
			<?= RelazioniQuiz($riga,$pos) ?>                         
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
function RelazioniQuiz($riga, $rigapos) { ?>

<!-- ============================================ -->
<!--    Relazioni tra i pdc                       -->
<!-- ============================================ -->
	<tr id="RigaRelQuiz_<?=$rigapos?>">
    <td colspan="100" class="closed tdRelazione" >
		
    <div style="margin-left:20px;" id="divRel_Quiz_DomandaQuiz_<?=$rigapos?>" class="divRelazione" chiave="<?=$riga->IdQuiz?>" nomepdc="patente\Quiz" nomerelaz="Quiz_DomandaQuiz">
		<div class="titolorelaz"><a class="refresh_btn cis-button btn_riga" href="javascript:void(0)" onclick="caricaRelazione(this)">
                        <i class="fa fa-sync"></i>
		</a>
		<?php echo frontend\controllers\BaseController::linkwin('Aggiungi una Domanda|fa-plus', 'patente/domandaquiz/create', ['IdQuiz' => $riga->IdQuiz], 'Apri per inserimento','caricaRelazione(this.atag)'); ?>
		&#xA0;
		<span class="titolo1">Relazione DomandaQuiz</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<?php RelazioneQuiz_DomandaQuiz($riga,$rigapos) ?>
		</div>
				
    </td>
	</tr>
<?php } ?>


		
<?php 
function RelazioneQuiz_DomandaQuiz($righe, $rigapos) { ?>
	<div class="divLista">
	<!--xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template> -->
	<table border="0" cellpadding="2" cellspacing="0" class="tabLista" id="tabListaQuiz_DomandaQuiz_<?=$rigapos?>" nomepdc="Quiz">
		<?= IntestaTabellaDomandaQuiz()?>
                <?php foreach ($righe->domandaquiz as $value) {
                    RecordDomandaQuiz($value,$rigapos);
                 }?>
	</table>
	</div>
<?php } ?>	
		
<?php 
function RelazioneQuiz_Test($righe, $rigapos) { ?>
	<div class="divLista">
	<!--xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template> -->
	<table border="0" cellpadding="2" cellspacing="0" class="tabLista" id="tabListaQuiz_Test_<?=$rigapos?>" nomepdc="Quiz">
		<?= IntestaTabellaTest()?>
                <?php foreach ($righe as $value) {
                    RecordTest($value,$rigapos);
                 }?>
	</table>
	</div>
<?php } ?>	
		

<?php 
function IntestaTabellaDomandaQuiz() { ?>
<tr>
<th style="min-width:180px"></th>

     <th data-nomecol="IdDomandaTest" >IdDomandaTest</th>

     <th data-nomecol="IdQuiz" >IdQuiz</th>

     <th data-nomecol="IdDomanda" >IdDomanda</th>

</tr>
<?php } ?>	


<!-- ============================================ -->
<!--    Righe tabella                             -->
<!-- ============================================ -->
<?php 
function RecordDomandaQuiz($rigarel, $pos) { ?>

   <tr id='RigaDomandaQuiz_<?=$pos?>' chiave='<?=$rigarel->IdDomandaTest?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\BaseController::linkwin('Edit|fa-edit', 'patente/domandaquiz/update', ['IdDomandaTest'=>$rigarel->IdDomandaTest], 'Apri per modifica','caricaRelazione(this.atag)'); ?>
		</td>

		<td><?=$rigarel->IdDomandaTest?></td>

		<td><?=$rigarel->IdQuiz?></td>

		<td><?=$rigarel->IdDomanda?><?=$rigarel->domanda->Asserzione ?></td>

		</tr >

	<!--xsl:call-template name="RelazioniDomandaQuiz"/-->
<?php } ?>	

		

<?php 
function IntestaTabellaTest() { ?>
<tr>
<th style="min-width:180px"></th>

     <th data-nomecol="IdTest" >IdTest</th>

     <th data-nomecol="IdQuiz" >IdQuiz</th>

</tr>
<?php } ?>	


<!-- ============================================ -->
<!--    Righe tabella                             -->
<!-- ============================================ -->
<?php 
function RecordTest($rigarel, $pos) { ?>

   <tr id='RigaTest_<?=$pos?>' chiave='<?=$rigarel->IdTest?>'  class="<?=fmod($pos,2) == 1?'rigaDispari':'rigapari'; ?>">
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\BaseController::linkwin('Edit', 'patente/test/update', ['IdTest'=>$rigarel->IdTest], 'Apri per modifica'); ?>
		</td>

		<td><?=$rigarel->IdTest?></td>

		<td><?=$rigarel->IdQuiz?><?=$rigarel->quiz->nome ?></td>

		</tr >

	<!--xsl:call-template name="RelazioniTest"/-->
<?php } ?>	

