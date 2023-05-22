
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\busy\TipoOccupazione $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="tipooccupazione-search searchform">
    <style>
        .tipooccupazione-search .form-control {
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
	
	
	<?= $form->field($model,'IdArg') ->dropDownList(
			$combo['Argomento'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>

	<?= $form->field($model,'TpOccup')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
		<?= $form->field($model,'DsOccup')->textInput() ?>
		
	
    <div class="form-group-search">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    </fieldset>
</div>
