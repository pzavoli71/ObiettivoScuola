
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\abilitazione\ztrans . $model */

$this->title = 'Update ztrans:' . $model->idtrans;

\yii\web\YiiAsset::register($this);
?>
<div class="ztrans-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'combo' => isset($combo) ? $combo: null,
		// Eventuali items per i combo
        //'itemsTpOccup'=>$itemsTpOccup,        
    ]) ?>

</div>
