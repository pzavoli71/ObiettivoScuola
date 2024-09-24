
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\View;


    $models = $dataProvider->getModels();
    $model = $models[0];
    $this->title = 'Stampa risultato quiz ' . $model->IdQuiz . ' di <b>' . $model->user->username . '</b>';
    
?>

<!-- Inizio form -->
<div class="quiz-index">
    
    <h4><?= $this->title ?></h4>
    <p style="margin-bottom:0px; margin-top:5px"></p>    
    <h5><?= $model->DtInizioTest;?></h5>
    <p><?= $model->bPatenteAB == -1?'Patente AB':'Patente AM' ?> <?= ($SoloSbagliate === 'true' ? '(Preso da risposte solo sbagliate)':'') ?></p>
		
    <?php foreach ($model->domandaquiz as $value) {
        if ( $SoloSbagliate === 'false') {
            RecordDomandaQuiz($value,$rigapos, $OscuraRisposte);
            echo("<br/><br/>");
        } else {
            $trovaterispsbagliate = false;
            foreach ($value->rispquiz as $rispquiz) {
                if ( $rispquiz->bControllata == -1 and $rispquiz->EsitoRisp == -1) {
                    $trovaterispsbagliate = true;
                }
            }
            if ( $trovaterispsbagliate ) {
                RecordDomandaQuiz($value,$rigapos, $OscuraRisposte);
                echo("<br/><br/>");                
            }
        }
    }?>

	
</div> <!-- div generale -->
		



<?php 
// ============================================ -->
//    Righe tabella                             -->
// ============================================ -->
function RecordDomandaQuiz($rigarel, $pos, $OscuraRisposte) { ?>
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
                    <?php if ($OscuraRisposte == 'false') { ?>
                    Hai risposto <b><?php if ( $value->RespVero == -1) echo('Vero'); else echo('falso');?></b>
                    <?php } ?>
                </td>
                <td style="width:10%" >
                    <?php if ($OscuraRisposte == 'false') { ?>
                    <b><?php if ( $value->bControllata == -1 && $value->EsitoRisp == -1) echo('Risposta Sbagliata');?></b>
                    <?php } ?>
                </td>
                </tr>
            </table>
    <?php }?>
<?php } ?>	

                