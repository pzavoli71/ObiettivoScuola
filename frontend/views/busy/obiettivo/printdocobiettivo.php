
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

    <!--table>
        <tr>
            <th width="30%">Data documento</th>
            <th width="70%">Nota documento</th>
        </tr>
    </table-->
	
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
        $valore = preg_replace('/([<a-zA-Z=>:\/\.0-9\-;\s"]+)(<iframe)([\s\W\w<>\-"]+)(<\/iframe>)([\s\W\w<>\-"]*)/i', '$1 $5', $rigarel->NotaDoc); 
        $valore = preg_replace('/\/uploads/i', 'uploads', $valore); 
        echo ($valore);  
    ?>            
<?php } ?>	

<?php
function RecordDocObiettivo2($rigarel, $pos) { ?>
   <tr >
		<td><?=$rigarel->DtDoc?><br/>
                <?php if (str_contains($rigarel->PathDoc,".pdf") || str_contains($rigarel->PathDoc,".doc")) {
                    echo '<a target="blank" href="uploads/' . $rigarel->PathDoc .'">Scarica documento</a>';
                }
                ?>
                <?php if (str_contains($rigarel->PathDoc,".jpg") || str_contains($rigarel->PathDoc,".jpeg") ||
                         str_contains($rigarel->PathDoc,".png") || str_contains($rigarel->PathDoc,".tiff")) { ?>
                <img class="imgdoc" src="<?=Url::to('@web/uploads/' . $rigarel->PathDoc)?>"/>
                <?php }?>
                </td>

		<td>
                    <?php $valore = preg_replace('/([<a-zA-Z=>:\/\.0-9\-;\s"]+)(<iframe)([\s\W\w<>\-"]+)(<\/iframe>)([\s\W\w<>\-"]*)/i', '$1 $5', $rigarel->NotaDoc); 
                            ?>            
                    <?php $valore = preg_replace('/\/uploads/i', 'uploads', $valore); 
                          echo ($valore);  
                            ?>            
                    <!--img src="uploads/1/e10fd3a6e0-avvoltoio-copia.jpg" style="width: 287px; height: 267px;" width="287" height="267"-->
                </td>

		</tr >

<?php } ?>	
                