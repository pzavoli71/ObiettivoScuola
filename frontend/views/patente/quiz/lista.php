
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

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
            ListaRelQuiz_DomandaQuiz($model, $rigapos);
		}
				
        if ($nomerelaz == "Quiz_Test") {
            ListaRelQuiz_Test($model, $rigapos);
		}
		
    }    
?>

<script language="javascript">
    setTimeout(function() {AppGlob.resize2(window);},300);
</script>

<?php function creaLista($thisobj, $dataProvider, $searchModel) {?>

<script type="text/javascript">
// Apre una riga sotto quella corrente, per visualizzare le relazioni aperte con altri pdc
function apriRigaRelazioni(chiave, nomepdc, riga, rigarel) {
    // La riga corrispondente all'elemento selezionato e' la seguente
	var spezzanome = nomepdc.split('.');
	var nome = spezzanome[spezzanome.length - 1];                   
	var tr = riga; 
	var chiavi = chiave.split('_'); 
	if ( nome == 'Quiz') {
		var IdQuiz = chiavi[0];
	} else if (nome == 'DomandaQuiz') {
		var IdDomandaTest = chiavi[0];
	} else if (nome == 'Test') {
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
	if ( nome == 'Quiz') {
		var IdQuiz = chiavi[0];
	} else if (nome == 'DomandaQuiz') {
		var IdDomandaTest = chiavi[0];
	} else if (nome == 'Test') {
		var IdTest = chiavi[0];

	}
    dati['Id'] = chiavi[0];
	<?php $currentcontroller = Yii::$app->controller->id; ?>
	
	AppGlob.reloadRelazione(<?= Url::toRoute($currentcontroller . "/reloadrelazione")?>,nomepdc,nomerelazione,dati,odivRelaz, function(dati, data) {
    
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
		<?php echo frontend\controllers\SiteController::linkwin('Aggiungi', 'patente/quiz/create', [], 'Inserisci un nuovo elemento'); ?>
		<a class="btn btn-success" onclick="apriForm(this, '/index.php?r=quiz/create')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-plus" aria-hidden="true"></span>Create Quiz</a>	
    </p>

    <?= Yii::$app->session->getFlash('kv-detail-success'); ?>

    <?php
		$models = $dataProvider->getModels();?>
		<table class="tabLista kv-grid-table table table-bordered table-striped kv-table-wrap"> 
		<tr >
			<th style="min-width:180px"></th>
			<th data-nomecol='CdUtente'>CdUtente</th>
			<th data-nomecol='IdQuiz'>IdQuiz</th>
			<th data-nomecol='DtCreazioneTest'>DtCreazioneTest</th>
			<th data-nomecol='DtInizioTest'>DtInizioTest</th>
			<th data-nomecol='EsitoTest'>EsitoTest</th>
			<th data-nomecol='DtFineTest'>DtFineTest</th>
			<th data-nomecol='bRispSbagliate'>bRispSbagliate</th>

		</tr>

		<?php
		
		$pos = 1;
		foreach ($models as $riga) {?>
			<tr id='RigaQuiz_<?=$pos?>' chiave="<?=$riga->IdQuiz?>">
				<td><?= showToggleInrelations($riga,$pos,true) ?>
					<?php echo frontend\controllers\SiteController::linkwin('Edit', 'patente/quiz/update', ['IdQuiz'=>$riga->IdQuiz], 'Apri per modifica'); ?>
					<a onclick="apriForm(this, '/index.php?r=quiz/update&IdQuiz=<?=$riga->IdQuiz?>', 'document.location.reload(false)')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-pencil-alt" aria-hidden="true"></span></a>				
				</td>   
				<td><?= $riga->CdUtente?> </td>
				<td><?= $riga->IdQuiz ?></td>
				<td><?= $riga->DtCreazioneTest ?></td>
				<td><?= $riga->DtInizioTest ?></td>
				<td><?= $riga->EsitoTest ?></td>
				<td><?= $riga->DtFineTest ?></td>
				<td><?= $riga->bRispSbagliate ?></td>
		
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
    <xsl:choose>
      <xsl:when test="(position() mod 2) = 1"><xsl:attribute name="class">rigaDispari</xsl:attribute></xsl:when>
      <xsl:otherwise><xsl:attribute name="class">rigaPari</xsl:attribute></xsl:otherwise>
    </xsl:choose>
    <td colspan="100" class="closed tdRelazione" >
		
    <div style="margin-left:20px;" id="divRel_Quiz_DomandaQuiz_<?=$rigapos?>" class="divRelazione" chiave="<?=$riga->IdQuiz?>" nomepdc="patente\Quiz" nomerelaz="DomandaQuiz">
		<div class="titolorelaz"><a class="refresh_btn cis-button" href="javascript:void(0)" onclick="caricaRelazione(this)">
		<i class="fa fa-refresh"/>
		</a>
		<?php echo frontend\controllers\SiteController::linkwin('Aggiungi un DomandaQuiz', 'patente/domandaquiz/create', [], 'Apri per inserimento'); ?>
		&#xA0;
		<span class="titolo1">Relazione DomandaQuiz</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<?php RelazioneQuiz_DomandaQuiz($riga->domandaquiz,$rigapos) ?>
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
                <?php foreach ($righe as $value) {
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

   <tr id='RigaDomandaQuiz_<?=$pos?>' chiave='<?=$rigarel->IdDomandaTest?>'>
    <xsl:choose>
      <xsl:when test="(position() mod 2) = 1"><xsl:attribute name="class">rigaDispari</xsl:attribute></xsl:when>
      <xsl:otherwise><xsl:attribute name="class">rigaPari</xsl:attribute></xsl:otherwise>
    </xsl:choose>
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\SiteController::linkwin('Edit', 'patente/domandaquiz/update', ['IdDomandaTest'=>$rigarel->IdDomandaTest], 'Apri per modifica'); ?>
		</td>

		<td><?=$rigarel->IdDomandaTest?></td>

		<td><?=$rigarel->IdQuiz?><?=$rigarel->quiz->nome ?></td>

		<td><?=$rigarel->IdDomanda?><?=$rigarel->domanda->nome ?></td>

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

   <tr id='RigaTest_<?=$pos?>' chiave='<?=$rigarel->IdTest?>'>
    <xsl:choose>
      <xsl:when test="(position() mod 2) = 1"><xsl:attribute name="class">rigaDispari</xsl:attribute></xsl:when>
      <xsl:otherwise><xsl:attribute name="class">rigaPari</xsl:attribute></xsl:otherwise>
    </xsl:choose>
		<td><?= showToggleInrelations($rigarel,$pos,true) ?>	
			<?php echo frontend\controllers\SiteController::linkwin('Edit', 'patente/test/update', ['IdTest'=>$rigarel->IdTest], 'Apri per modifica'); ?>
		</td>

		<td><?=$rigarel->IdTest?></td>

		<td><?=$rigarel->IdQuiz?><?=$rigarel->quiz->nome ?></td>

		</tr >

	<!--xsl:call-template name="RelazioniTest"/-->
<?php } ?>	

