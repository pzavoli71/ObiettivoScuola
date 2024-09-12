<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\View;

    $models = $dataProvider->getModels();
    ?>
    <h4><?= 'Stampa quiz errati di <b>' . $models[0]->user->username . '</b>';     ?></h4>
    
    <?php 
    
    foreach ($models as $model) {
        StampaModello($model, $this, $rigapos);    
    }    
    ?>

    <?php 
    function StampaModello($model, $thisobj, $rigapos) {
        $thisobj->title = 'Stampa risultato quiz ' . $model->IdQuiz . ' di <b>' . $model->user->username . '</b>';    
    ?>

<!-- Inizio form -->
<div class="quiz-index">
    <p style="margin-bottom:0px; margin-top:5px"></p>    
    <!--p><?= $model->bPatenteAB == -1?'Patente AB':'Patente AM' ?></p-->
		
    <?php foreach ($model->domandaquiz as $value) {
        $trovaterispsbagliate = false;
        foreach ($value->rispquiz as $rispquiz) {
            if ( $rispquiz->bControllata == -1 and $rispquiz->EsitoRisp == -1) {
                $trovaterispsbagliate = true;
            }
        }
        if ( $trovaterispsbagliate ) {
            RecordDomandaQuiz($value,$rigapos);
            echo("<br/><br/>");                
        }
    }?>

	
</div> <!-- div generale -->
	
    <?php }?>



<?php 
function RecordDomandaQuiz($rigarel, $pos) { ?>
<p>
    <?php if ($rigarel->domanda->linkimg != '' && $rigarel->domanda->linkimg != '0.jpg') { ?>
        <img border="1" src="quiz/immagini/<?=$rigarel->domanda->linkimg?>" height="70" style="margin-right:10px"/>
    <?php } ?>
    <b><?=$rigarel->domanda->Asserzione?></b>
</p>    
    <?php foreach ($rigarel->rispquiz as $value) {?>
            <table style="width:100%">
                <tr>
                <td style="width:70%">
                    <?php echo($value->domanda->Asserzione) ?>
                </td>
                <td style="width:20%"  >
                    Hai risposto <b><?php if ( $value->RespVero == -1) echo('Vero'); else echo('falso');?></b>
                </td>
                <td style="width:10%" >
                    <b><?php if ( $value->bControllata == -1 && $value->EsitoRisp == -1) echo('Risposta Sbagliata');?></b>
                </td>
                </tr>
            </table>
    <?php }?>
<?php } ?>	

                