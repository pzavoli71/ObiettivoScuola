
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\busy\Obiettivo $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="obiettivo-search searchform">
    <style>
        .obiettivo-search .form-control {
            /*width:initial;*/
        }   
        #obiettivosearch-dtinizioobiettivo-disp {
            width:100px;
        }
        #obiettivosearch-dtfineobiettivo-disp {
            width:100px;
        }
    </style>
    <fieldset>
        <legend>Inserisci il filtro</legend>
	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
        'action' => ['index'],
        'method' => 'get',		
	]); ?>
	
	
	<?= $form->field($model,'IdSoggetto') ->dropDownList(
			$combo['Soggetto'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

	<?= $form->field($model,'IdArg') ->dropDownList(
			$combo['Argomento'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	)->label('Argomento'); ?>
        
	<?= $form->field($model,'TpOccup') ->dropDownList(
			$combo['TipoOccupazione'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

		<?= $form->field($model,'DtInizioObiettivo')->widget(DateControl::className(),
			['type'=>DateControl::FORMAT_DATETIME,  
			'convertFormat'=>false,
			]); 
		?>													
		
		<?= $form->field($model,'NotaObiettivo')->textInput() ?>
		
	
    <div class="form-group-search">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </fieldset>
</div>
