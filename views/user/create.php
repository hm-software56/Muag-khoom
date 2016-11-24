<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="line_bottom">ປ້ອນ​ລາຍ​ລະ​ອຽດ​ຜູ້​ໃຊ້​ລະ​ບົບ</div>
    <br/>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
</div>
