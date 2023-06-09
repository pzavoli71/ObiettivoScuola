
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\busy\Obiettivo $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="obiettivo-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
	<?= $form->field($model,'IdSoggetto') ->dropDownList(
			$combo['Soggetto'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>
	<?= $form->field($model,'IdArg') ->dropDownList(
			$combo['Argomento'],           // Flat array ('id'=>'label')
                        [
                            'prompt' => Yii::t('app','scegli argomento'),
                            'onchange'=>'
                                href = "' . Yii::$app->urlManager->createUrl(["busy/obiettivo/reloadcombo","nomecombo"=>"TpOccup"]) . '";' .
                                'href += "&params={\"IdArg\":\"" + $(this).val() + "\"}";' .
                                'href += "&currcombovalue=" + $( "select#obiettivo-tpoccup" ).val();' .
                                '$.get(href, function(data) {' .
                                '$( "select#obiettivo-tpoccup" ).html( data ).focus()' .
                                '})'
                        ]                
	); ?>

	<?= $form->field($model,'TpOccup') ->dropDownList(
			$combo['TipoOccupazione'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

	<?= $form->field($model,'IdObiettivo')->hiddenInput()->label(false); ?>	
		
		<?= $form->field($model,'DtInizioObiettivo')->widget(DateControl::className(),
			['type'=>DateControl::FORMAT_DATETIME,  
			'convertFormat'=>false,
			]); 
		?>				
				
		<?= $form->field($model,'DescObiettivo')->widget(\common\components\NewRedactor::className());?>
		
		<?= $form->field($model,'DtScadenzaObiettivo')->widget(DateControl::className(),
			['type'=>DateControl::FORMAT_DATETIME,  
			'convertFormat'=>false,
			]); 
		?>				
				
	<?= $form->field($model,'MinPrevisti')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
		<?= $form->field($model,'DtFineObiettivo')->widget(DateControl::className(),
			['type'=>DateControl::FORMAT_DATETIME,  
			'convertFormat'=>false,
			]); 
		?>				
				
		<?= $form->field($model,'NotaObiettivo')->textInput() ?>
		
	<?= $form->field($model,'PercCompletamento')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_DECIMAL_PARAMS_WIDGET,
	); ?>
		

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
