<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */

$this->title = Yii::t('app', 'Create Branch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Branches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-create">
    <div class="line_bottom"><?= Yii::t('app', 'ປ້ອນສາຂາ') ?></div>
    <br/>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
