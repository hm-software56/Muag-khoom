<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ShopProfile */

$this->title = 'Create Shop Profile';
$this->params['breadcrumbs'][] = ['label' => 'Shop Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
