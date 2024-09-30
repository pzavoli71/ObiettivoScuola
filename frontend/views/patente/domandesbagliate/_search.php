
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var common\models\patente\DomandeSbagliate $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="domandesbagliate-search searchform">
    <style>
        .domandesbagliate-search .form-control {
            /*width:initial;*/
        }    
    </style>

    <fieldset>
        <legend>Inserisci il filtro</legend>
	<?php $form = ActiveForm::begin([
		//'enableAjaxValidation' => true,
        'action' => ['lista'],
        'method' => 'get',		
	]); ?>
	<?= $form->field($model,'id') ->dropDownList(
			$combo['users'],           // Flat array ('id'=>'label')
			['prompt'=>'']    // options
	); ?>	
	
	<?= $form->field($model,'ConteggioErrori')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
	<?= $form->field($model,'ConteggioQuanteVolte')->widget(\yii\widgets\MaskedInput::className(),
			\frontend\controllers\BaseController::$MASK_INTEGER_PARAMS_WIDGET,
	); ?>
		
	
    <div class="form-group-search">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	</fieldset>
</div>
