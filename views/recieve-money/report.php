<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>
<div class="line_bottom">ລາຍງານຈຳ​ນວນ​ເງີນ​ເປັນ​ອາ​ທິດ</div>
<br/>
<div class="table-responsive">
    <table class="table table-condensed">
        <tr>
            <th>ລຳ​ດັບ</th>
            <th>ວັນ​ທີ​ຮັບ</th>
            <th>ປະເພດ​ລາຍ​ຮັບ</th>
            <th>​ຈຳ​ນວນ​ເງີນ</th>
            <th>ລາຍ​ລະ​ອຽດ</th>
        </tr>
        <?php
        $i = 0;
        $amount_total = 0;
        foreach ($model as $models) {
            $i++;
            $amount_total+=$models->amount;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $models->date ?></td>
                <td><?= $models->tyeReceive->name ?></td>
                <td><?= number_format($models->amount, 2) ?></td>
                <td><?= $models->description ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທີ​ຮັບທັງ​ໝົດ</b></td>
            <td><b><?= number_format($amount_total, 2) ?></b></td>
            <td></td>
        </tr>
    </table>
</div>

<div class="line_bottom">ລາຍງານຈຳ​ນວນ​ເງີນ​ເປັນ​ເດືອນ</div>
<br/>
<div class="table-responsive">
    <table class="table table-condensed">
        <tr>
            <th>ລຳ​ດັບ</th>
            <th>ວັນ​ທີ​ຮັບ</th>
            <th>ປະເພດ​ຮັບ</th>
            <th>​ຈຳ​ນວນ​ເງີນ</th>
            <th>ລາຍ​ລະ​ອຽດ</th>
        </tr>
        <?php
        $i = 0;
        $amount_total = 0;
        foreach ($model_m as $models) {
            $i++;
            $amount_total+=$models->amount;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $models->date ?></td>
                <td><?= $models->tyeReceive->name ?></td>
                <td><?= number_format($models->amount, 2) ?></td>
                <td><?= $models->description ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທີ​ຮັບທັງ​ໝົດ</b></td>
            <td><b><?= number_format($amount_total, 2) ?></b></td>
            <td></td>
        </tr>
    </table>

</div>


<div class="line_bottom">ລາຍງານຈຳ​ນວນ​ເງີນ​ເປັນ​ປີ</div>
<br/>
<div class="table-responsive">
    <table class="table table-condensed">
        <tr>
            <th>ລຳ​ດັບ</th>
            <th>ວັນ​ທີ​ຮັບ</th>
            <th>ປະເພດ​ຮັບ</th>
            <th>​ຈຳ​ນວນ​ເງີນ</th>
            <th>ລາຍ​ລະ​ອຽດ</th>
        </tr>
        <?php
        $i = 0;
        $amount_total = 0;
        foreach ($model_y as $models) {
            $i++;
            $amount_total+=$models->amount;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $models->date ?></td>
                <td><?= $models->tyeReceive->name ?></td>
                <td><?= number_format($models->amount, 2) ?></td>
                <td><?= $models->description ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທີ​ຮັບທັງ​ໝົດ</b></td>
            <td><b><?= number_format($amount_total, 2) ?></b></td>
            <td></td>
        </tr>
    </table>

</div>