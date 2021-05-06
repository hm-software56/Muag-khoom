<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Branch */

$this->title = Yii::t('app', 'Update Branch: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Branches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="branch-update">
    <div class="line_bottom"><?=Yii::t('app','ແກ້ໄຂສາຂາ')?></div>
    <br/>
    <?= $this->render('_form', [
        'model' => $model,
        'profile_branch' => $profile_branch
    ]) ?>

</div>
