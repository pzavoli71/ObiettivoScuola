
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\abilitazione\zUtGr $model */

$this->title = 'Create zUtGr';

\yii\web\YiiAsset::register($this);
?>
<div class="zutgr-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'combo' => isset($combo) ? $combo: null,
		// Eventuali items per i combo
        //'itemsTpOccup'=>$itemsTpOccup,        
    ]) ?>

</div>
