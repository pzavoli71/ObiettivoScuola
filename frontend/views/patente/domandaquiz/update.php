
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\patente\DomandaQuiz . $model */

$this->title = 'Update DomandaQuiz:' . $model->IdDomandaTest;

\yii\web\YiiAsset::register($this);
?>
<div class="domandaquiz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'combo' => isset($combo) ? $combo: null,
		// Eventuali items per i combo
        //'itemsTpOccup'=>$itemsTpOccup,        
    ]) ?>

</div>
