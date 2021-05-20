<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StillPay */

$this->title = Yii::t('app', 'Create Still Pay');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Still Pays'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="still-pay-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
