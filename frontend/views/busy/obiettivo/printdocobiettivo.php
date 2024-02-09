
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\View;

    $this->title = 'Stampa obiettivo';

    $models = $dataProvider->getModels();
    $model = $models[0];
    
?>

<!-- Inizio form -->
<div class="quiz-index">
    
    <h4><?= Html::encode($thisobj->title) ?></h4>
    <p style="margin-bottom:0px; margin-top:5px">
    </p>
    
    <h3>
    <?= $model->soggetto->NomeSoggetto;?>
    </h3>
    <p>$model->tipooccupazione->DsOccup</p>
    <p>$model->DescObiettivo</p>
		
    <?php if ( $loadable) 
        $rigapos = 1; ?>
    <table>
        <?php foreach ($model->docobiettivo as $value) {
            RecordDocObiettivo($value,$rigapos);
        }?>
    </table>
	
</div> <!-- div generale -->
		



<?php 
// ============================================ -->
//    Righe tabella                             -->
// ============================================ -->
function RecordDocObiettivo($rigarel, $pos) { ?>

   <tr id='RigaDocObiettivo_<?=$pos?>' chiave='<?=$rigarel->IdDocObiettivo?>' class="<?=fmod($pos,2) == 1?'rigaDispari':'rigaPari'; ?>">
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
                <?php if (str_contains($rigarel->PathDoc,".jpg") || str_contains($rigarel->PathDoc,".jpeg") ||
                         str_contains($rigarel->PathDoc,".png") || str_contains($rigarel->PathDoc,".tiff")) { ?>
                <img class="imgdoc" src="<?=Url::to('@web/uploads/' . $rigarel->PathDoc)?>"/>
                <?php }?>
                </td>

		<td><span class="headcol">Nota:</span><?=$rigarel->NotaDoc?></td>

		</tr >

<?php } ?>	

