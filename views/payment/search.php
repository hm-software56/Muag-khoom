<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action' => ['payment/report'], 'options' => ['autocomplete' => "off"],]); ?>
<b>ປະເພດ​ການ​ຈ່າຍ</b><br/>
<select name="type" class="form-control" onchange="this.form.submit()">
    <option> </option>
    <?php
    $types = app\models\TypePay::find()->all();
    foreach ($types as $type) {
        ?>
        <option value="<?= $type->id ?>"><?= $type->name ?></option>
        <?php
    }
    ?>
</select>
<?php ActiveForm::end(); ?>
