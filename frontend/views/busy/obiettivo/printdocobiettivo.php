
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
    
    <h4><?= Html::encode($this->title) ?></h4>
    <p style="margin-bottom:0px; margin-top:5px">
    </p>
    
    <h3>
    <?= $model->soggetto->NomeSoggetto;?>
    </h3>
    <p><?= $model->tipooccupazione->DsOccup?></p>
    <p><?= $model->DescObiettivo?></p>
		
    <?php foreach ($model->docobiettivo as $value) {
        RecordDocObiettivo($value,$rigapos);
        echo("<br/><br/>");
    }?>

	
</div> <!-- div generale -->
		



<?php 
// ============================================ -->
//    Righe tabella                             -->
// ============================================ -->
function RecordDocObiettivo($rigarel, $pos) { ?>
<p><b><?=$rigarel->DtDoc?></b></p>    
    <?php if (str_contains($rigarel->PathDoc,".pdf") || str_contains($rigarel->PathDoc,".doc")) {
        echo '<a target="blank" href="uploads/' . $rigarel->PathDoc .'">Scarica documento</a>';
    }?>
    <?php if (str_contains($rigarel->PathDoc,".jpg") || str_contains($rigarel->PathDoc,".jpeg") ||
             str_contains($rigarel->PathDoc,".png") || str_contains($rigarel->PathDoc,".tiff")) { ?>
    <img class="imgdoc" src="<?=Url::to('@web/uploads/' . $rigarel->PathDoc)?>"/>
    <?php }?>
    <?php 
        $valore = $rigarel->NotaDoc;
        $valore = str_replace('"=""', '', $valore); 
        if (str_contains($valore, '<iframe')) {
            $valore = preg_replace('/([<a-zA-Z=>:\/\.0-9\-;"èìòàùé\'\s"]+)(<iframe)([\s\W\w<>\-"]+)(<\/iframe>)([\s\W\w<>\-"]*)/i', '$1 $5', $valore); 
        }
        $valore = preg_replace('/\/uploads/i', 'uploads', $valore); 
        echo ($valore);  
    ?>            
<?php } ?>	

                