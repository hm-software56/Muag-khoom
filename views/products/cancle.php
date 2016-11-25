<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php
$form = ActiveForm::begin([ 'enableClientValidation' => true,
            'options' => [
                'id' => 'dynamic-form'
        ]]);
?>

<div class="row">
    <div class="col-xs-6 col-md-6">
        <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $product->image ?>" class="thumbnail img-responsive" />
    </div>
    <div class="col-xs-6 col-md-6">
        ລະ​ຫັດ: <?= $product->code ?>
        <br/>
        ຊື່: <?= $product->name ?>
        <br/>
        ລາ​ຄາ: <?= number_format($product->pricesale, 2) ?><br/>
        ຈຳ​ນວນທີ່​ຂາຍ​ແລ້ວ:
        <select name="qtt">
            <?php
            $i = 0;
            $sale = app\models\Sale::find()->where(['products_id' => $product->id])->all();
            foreach ($sale as $sale) {
                $i++;
                ?>
                <option value="<?= $i ?>"><?= $i ?></option>
                <?php
            }
            ?>
        </select>
        <br/>
        <br/>
        <?= Html::submitButton('<span class="glyphicon glyphicon-save"></span> ຢັ້ງ​ຢືນ​ການ​ລືບ​ອອກ', ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
</div>
<?php
ActiveForm::end();
?>