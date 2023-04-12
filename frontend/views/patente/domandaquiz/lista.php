
<?php

use yii\helpers\Html;
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
				
        if ($nomerelaz == "DomandaQuiz_Quiz")
            ListaRelDomandaQuiz_Quiz($model, $rigapos);		
		
        if ($nomerelaz == "DomandaQuiz_RispQuiz")
            ListaRelDomandaQuiz_RispQuiz($model, $rigapos);
    }    
?>

<script language="javascript">
    setTimeout(function() {AppGlob.resize2(window)},300);
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
	if ( nome == 'DomandaQuiz') {
		var IdDomandaTest = chiavi[0];
	} else if (nome == 'Quiz') {
		var IdQuiz = chiavi[0];

	// Scommentare per fare il caricamento manuale ogni volta che si clicca sul + di questa relazione
    riga.next().find('.refresh_btn.btn_riga').click()
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
	if ( nome == 'DomandaQuiz') {
		var IdDomandaTest = chiavi[0];
	} else if (nome == 'Quiz') {
		var IdQuiz = chiavi[0];

    
    dati['Id'] = chiavi[0];
	$currentcontroller = Yii::$app->controller->id;
	
    AppGlob.reloadRelazione(Url::routeTo($currentcontroller . "/reloadrelazione",nomepdc,nomerelazione,dati,odivRelaz, function(dati, data) { 
    
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
    <?= $thisobj->render('_search', [
		'model' => $searchModel,
    ]) ?>

    <p>
		<a class="btn btn-success" onclick="apriForm(this, '/index.php?r=quiz/create')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-plus" aria-hidden="true"></span>Create Quiz</a>	
    </p>

    <?= Yii::$app->session->getFlash('kv-detail-success'); ?>

    <?php
		$models = $dataProvider->getModels();?>
		<table class="tabLista kv-grid-table table table-bordered table-striped kv-table-wrap"> 
		<?php
		IntestaTabella();		
		$pos = 1;
		foreach ($models as $riga) {?>
			<tr id='RigaQuiz_<?=$pos?>' chiave="<?=$riga->IdQuiz?>">
				<td><?= showToggleInrelations($riga,$pos,true) ?>
					<a onclick="apriForm(this, '/index.php?r=quiz/update&IdQuiz=<?=$riga->IdQuiz?>', 'document.location.reload(false)')" href="javascript:void(0)" title="Update" aria-label="Update" data-pjax="0"><span class="fas fa-pencil-alt" aria-hidden="true"></span></a>				
				</td>   
				<td><?= $riga->IdQuiz ?></td>
				<td><?= $riga->IdDomanda ?></td>
				<td><?= $riga->IdDomandaTest ?></td>
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
	
	
	
	
<?php function showToggleInrelations($model, $pos, $ramochiuso) { ?>
    <a pos="<?=$pos?>" href="javascript:void(0)" style="margin-left:1px; margin-right:5px" onclick="AppGlob.apriRigaRelazioni(this, '<?= str_replace("\\",".",get_class($model))?>')" >
        <i class="far <?php if ($ramochiuso == false) echo('fa-minus-square'); else  echo('fa-plus-square');?>">
        </i>        
    </a>
<?php } ?>

</div>

	

<?php 
// ============================================ 
//     Intestazione tabella                     
// ============================================ 
function IntestaTabella() { ?>
	<tr >
		<th style="min-width:180px"></th>
		<th data-nomecol='IdQuiz'>IdQuiz</th>
		<th data-nomecol='IdDomanda'>IdDomanda</th>
		<th data-nomecol='IdDomandaTest'>IdDomandaTest</th>

	</tr>
<?php } ?>


<?php 
// ============================================ 
//    Righe tabella                             
// ============================================ 
function Records() { ?>

<xsl:variable name="rigapos"><xsl:value-of select="position()"/></xsl:variable>
   <tr id='RigaDomandaQuiz_{position()}' chiave="{iddomandatest}">
    <xsl:choose>
      <xsl:when test="(position() mod 2) = 1"><xsl:attribute name="class">rigaDispari</xsl:attribute></xsl:when>
      <xsl:otherwise><xsl:attribute name="class">rigaPari</xsl:attribute></xsl:otherwise>
    </xsl:choose>
		<td>
			<xsl:call-template name="BottoniRiga">
				<xsl:with-param name="nomepdc">DomandaQuiz</xsl:with-param>
				<xsl:with-param name="pos"><xsl:value-of select="position()"/></xsl:with-param>
				<xsl:with-param name="ramochiuso">true</xsl:with-param>
			</xsl:call-template>
			<xsl:call-template name = "linkwin" >
				<xsl:with-param name="href">/obiettivoscuola/patente/HDomandaQuiz?MTipo=V&amp;MPasso=2&amp;IdDomandaTest=<xsl:value-of select="iddomandatest"/></xsl:with-param>
				<xsl:with-param name="title">Modifica un DomandaQuiz</xsl:with-param>
				<xsl:with-param name="width">600</xsl:with-param>
				<xsl:with-param name="height">400</xsl:with-param>
				<!--xsl:with-param name="img"><xsl:value-of select="$ImgMod"/></xsl:with-param>
				<xsl:with-param name="class">btnModifica</xsl:with-param-->
				<xsl:with-param name="fa-class">fa-edit</xsl:with-param>
				<xsl:with-param name="class">cis-button</xsl:with-param>
				<!--xsl:with-param name="target">fmDomandaQuiz</xsl:with-param-->
				<xsl:with-param name="onunload">document.location.reload()</xsl:with-param>
				<xsl:with-param name="caption">Gestione DomandaQuiz</xsl:with-param>
			</xsl:call-template>

		</td>

		<td><xsl:value-of select="idquiz"/><xsl:value-of select="Quiz/nome"></xsl:value-of></td>

		<td><xsl:value-of select="iddomanda"/><xsl:value-of select="Domanda/nome"></xsl:value-of></td>

		<td><xsl:value-of select="iddomandatest"/></td>

		<!-- Scommentare queste righe per avere comandi da eseguire su ogni riga -->
		<!-- I comandi devono avere il permesso (su zTrans) del tipo  HLstElabCeliaci:ElaboraMeseSmac-->
		<!--td align="right" class="bottoni_comando">
 		    <xsl:call-template name="linkComando">
		    	<xsl:with-param name="href">/obiettivoscuola/patente/HSLstDomandaQuiz</xsl:with-param>
		    	<xsl:with-param name="nomecomando">ElaboraMeseSmac</xsl:with-param>
		    	<xsl:with-param name="chiave"><xsl:value-of select='IdDomandaTest'/></xsl:with-param>
		    	<xsl:with-param name="ParamServlet">{MTipo:'L',MPasso:'2'}</xsl:with-param>
					<xsl:with-param name="title">Testo per comando</xsl:with-param>
					<xsl:with-param name="fa-class">fa-calculator</xsl:with-param>
		    </xsl:call-template>

			<a href="javascript:void(0)"  style="margin-left:1px; margin-right:5px;font-size:1.5em" onclick="AppGlob.eseguiComando('/obiettivoscuola/patente/HSLstDomandaQuiz', 'CreaPiattaforma', '{iddomandatest}', {{MTipo:'L',MPasso:'2'}}, richiestaComando, comandoTerminato)" title="Elabora il comando">
				<i class="fa fa-calculator"></i>
			</a>
			<a href="javascript:void(0)"  style="margin-left:1px; margin-right:5px;font-size:1.5em" onclick="elaboraPiattaforma()" title="Stampa il report">
				<i class="fa fa-print"></i>
			</a>
		</td-->
		</tr >

	<xsl:call-template name="RelazioniDomandaQuiz"/>
</xsl:template>


<!-- ============================================ -->
<!--    Relazioni tra i pdc                       -->
<!-- ============================================ -->
<xsl:template name="RelazioniDomandaQuiz">
<xsl:param name="rigapos"><xsl:value-of select="position()"/></xsl:param>
	<tr id="RigaRelDomandaQuiz_{$rigapos}">
    <xsl:choose>
      <xsl:when test="(position() mod 2) = 1"><xsl:attribute name="class">rigaDispari</xsl:attribute></xsl:when>
      <xsl:otherwise><xsl:attribute name="class">rigaPari</xsl:attribute></xsl:otherwise>
    </xsl:choose>
    <td colspan="100" class="closed tdRelazione" >
		<!--xsl:choose>
		<xsl:when test="'1' = '2'"></xsl:when>
			<xsl:when test="count(ListaDomandaQuiz_RispQuiz/*[@progr or @result]) &gt; 0"><xsl:attribute name="class">open</xsl:attribute></xsl:when>
		</xsl:choose-->


    <div style="margin-left:20px;" id="divRel_DomandaQuiz_RispQuiz_{position()}" class="divRelazione" chiave="{iddomandatest}" nomepdc="sm.ciscoop.obiettivoscuola.pdc.patente.DomandaQuiz" nomerelaz="DomandaQuiz_RispQuiz">
		<div class="titolorelaz"><a class="refresh_btn cis-button" href="javascript:void(0)" onclick="caricaRelazione(this)">
		<i class="fa fa-refresh"/>
		</a>
		<xsl:call-template name = "linkwin" >
			<xsl:with-param name="href">/obiettivoscuola/patente/HRispQuiz?MTipo=I&amp;MPasso=1&amp;IdDomandaTest=<xsl:value-of select="iddomandatest"/></xsl:with-param>
			<xsl:with-param name="title">Aggiungi un RispQuiz</xsl:with-param>
			<xsl:with-param name="width">600</xsl:with-param>
			<xsl:with-param name="height">400</xsl:with-param>
			<xsl:with-param name="fa-class">fa-plus-circle</xsl:with-param>
			<xsl:with-param name="class">cis-buttonhref cis-btn-i</xsl:with-param>
			<xsl:with-param name="onunload">caricaRelazione(this.atag)</xsl:with-param>
			<xsl:with-param name="caption">Gestione RispQuiz</xsl:with-param>
		</xsl:call-template>
		&#xA0;
		<span class="titolo1">Relazione RispQuiz</span>
		<div class="btn_minimax" title="Minimizza"><i class="fa fa-window-minimize"></i></div>
		</div>
		<xsl:apply-templates select="DomandaQuiz_RispQuiz" mode="tmlRel"><xsl:with-param name="pos"><xsl:value-of select="position()"/></xsl:with-param></xsl:apply-templates>
		</div>
		

    </td>
	</tr>
</xsl:template>


<xsl:template match="ListaDomandaQuiz_RispQuiz" mode="tmlRel" >
<xsl:param name="pos"/>
		<xsl:if test="count(*[@progr or @result]) &gt; 0">
		<div class="divLista">
		<xsl:call-template name="PaginatoreRelazione"><xsl:with-param name="caricaFunction">caricaRelazione(this)</xsl:with-param></xsl:call-template>
		<table border="0" cellpadding="2" cellspacing="0" class="tabLista" id="tabListaDomandaQuiz_RispQuiz_{$pos}" nomepdc="DomandaQuiz">
			<xsl:call-template name="IntestaTabellaRispQuiz"/>
			<xsl:apply-templates select = "*[@progr or @result]" mode="lista" />
		</table>
		<!-- Scommentare per fare una transazione T con uesta tabella <script language="javascript">
				$('#tabListaDomandaQuiz_RispQuiz_<xsl:value-of select="$pos"/>').cisTTrans();
		</script-->
		</div>
		</xsl:if>
</xsl:template>

<xsl:template name="IntestaTabellaRispQuiz">
<tr>
<th style="min-width:180px"></th>

     <th data-nomecol="IdRispTest" >IdRispTest</th>

     <th data-nomecol="RespVero" >RespVero</th>

     <th data-nomecol="RespFalso" >RespFalso</th>

     <th data-nomecol="bControllata" >bControllata</th>

     <th data-nomecol="EsitoRisp" >EsitoRisp</th>

     <th data-nomecol="IdDomanda" >IdDomanda</th>

     <th data-nomecol="IdDomandaTest" >IdDomandaTest</th>

</tr>
</xsl:template>


<!-- ============================================ -->
<!--    Righe tabella                             -->
<!-- ============================================ -->
<xsl:template match="RispQuiz" mode="lista" >

   <tr id='RigaRispQuiz_{position()}' chiave='{IdRispTest}'>
    <xsl:choose>
      <xsl:when test="(position() mod 2) = 1"><xsl:attribute name="class">rigaDispari</xsl:attribute></xsl:when>
      <xsl:otherwise><xsl:attribute name="class">rigaPari</xsl:attribute></xsl:otherwise>
    </xsl:choose>
		<td>
			<xsl:call-template name="BottoniRiga">
				<xsl:with-param name="nomepdc">RispQuiz</xsl:with-param>
				<xsl:with-param name="pos"><xsl:value-of select="position()"/></xsl:with-param>
				<xsl:with-param name="ramochiuso">true</xsl:with-param>
			</xsl:call-template>
			<xsl:call-template name = "linkwin" >
				<xsl:with-param name="href">/obiettivoscuola/patente/HRispQuiz?MTipo=V&amp;MPasso=2&amp;IdRispTest=<xsl:value-of select="IdRispTest"/></xsl:with-param>
				<xsl:with-param name="title">Modifica un RispQuiz</xsl:with-param>
				<xsl:with-param name="width">600</xsl:with-param>
				<xsl:with-param name="height">400</xsl:with-param>
				<xsl:with-param name="fa-class">fa-edit</xsl:with-param>
				<xsl:with-param name="class">cis-buttonhref</xsl:with-param>
				<!--xsl:with-param name="img"><xsl:value-of select="$ImgMod"/></xsl:with-param>
				<xsl:with-param name="class">btnModifica</xsl:with-param>
				<xsl:with-param name="target">fmRispQuiz</xsl:with-param-->
				<xsl:with-param name="onunload">caricaRelazione(this.atag)</xsl:with-param><!--$("#divRel_DomandaQuiz_RispQuiz_<xsl:value-of select='IdDomandaTest'/> > div > a.refresh_btn").click()-->
				<xsl:with-param name="caption">Gestione RispQuiz</xsl:with-param>
			</xsl:call-template>

		</td>

		<td><xsl:value-of select="IdRispTest"/></td>

		<td><xsl:value-of select="RespVero"/></td>

		<td><xsl:value-of select="RespFalso"/></td>

		<td><xsl:value-of select="bControllata"/></td>

		<td><xsl:value-of select="EsitoRisp"/></td>

		<td><xsl:value-of select="IdDomanda"/><xsl:value-of select="Domanda/nome"></xsl:value-of></td>

		<td><xsl:value-of select="IdDomandaTest"/><xsl:value-of select="DomandaQuiz/nome"></xsl:value-of></td>

		</tr >

	<!--xsl:call-template name="RelazioniRispQuiz"/-->
</xsl:template>

