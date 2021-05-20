<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Currency */

$this->title = Yii::t('models', 'Update Currency: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Currencies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('models', 'Update');
?>
<div class="currency-update">
<div class="line_bottom"><?=Yii::t('models','ແກ້​ໄຂສະ​ກຸນ​ເງີນ')?></div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
