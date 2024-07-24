<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
/** @var yii\web\View $this */
/** @var common\models\patente\Quiz $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="quiz-form">

	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
	]); ?>
	
	
		<?= $form->field($model,'id') ->dropDownList(
                    $combo['users'],           // Flat array ('id'=>'label')
                    ['prompt'=>'']    // options
                ); ?>
	
		<?= $form->field($model,'IdQuiz')->hiddenInput()->label(false);?>
	
		<?= $form->field($model,'DtCreazioneTest')->widget(DateControl::className(),
    ['type'=>DateControl::FORMAT_DATETIME,  
        'convertFormat'=>false,
        ]); 
?>
	<?php if (empty($inserting)) {?>
		<?= $form->field($model,'DtInizioTest')->widget(DateControl::className(),
    ['type'=>DateControl::FORMAT_DATETIME,  
        'convertFormat'=>false,
        ]); 
?>
    
		<?= $form->field($model,'EsitoTest')->widget(\yii\widgets\MaskedInput::className(),
                    \frontend\controllers\BaseController::$MASK_DECIMAL_PARAMS_WIDGET,
                    ); ?>

	
		<?= $form->field($model,'DtFineTest')->widget(DateControl::className(),
                ['type'=>DateControl::FORMAT_DATETIME,  
                    'convertFormat'=>false,
                    ]); 
        ?>
    
        <?php } ?>

        <?= $form->field($model,'bPatenteAB')->checkbox(['uncheck' => '0','value'=>'-1'])->label(false); ?>

        <?= $form->field($model,'bRispSbagliate')->checkbox(['uncheck' => '0','value'=>'-1'])->label(false); ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
