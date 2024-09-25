
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\patente\Quiz $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="quiz-search searchform">
    <style>
        .quiz-search .form-control {
            /*width:initial;*/
        }    
    </style>

    <fieldset>
        <legend>Inserisci il filtro</legend>
	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
        'action' => ['index'],
        'method' => 'get',		
	]); ?>
	
	
	<?= $form->field($model,'id') ->dropDownList(
			$combo['users'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

	<?= $form->field($model,'IdQuiz')->label('Id Quiz'); ?>		
	<?= $form->field($model,'IdDomanda')->label('Id Domanda'); ?>		
				
		<?= $form->field($model,'DtInizioTest')->widget(DateControl::className(),
			['type'=>DateControl::FORMAT_DATETIME,  
			'convertFormat'=>false,
			]); 
		?>				
				
		<?= $form->field($model,'DtFineTest')->widget(DateControl::className(),
			['type'=>DateControl::FORMAT_DATETIME,  
			'convertFormat'=>false,
			]); 
		?>				

	
    <div class="form-group-search">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	</fieldset>
</div>
