<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
?>
<div class="line_bottom">ລາຍງານຈຳ​ນວນ​ເງີນ​ເປັນ​ອາ​ທິດ
    <?php
    echo Html::a('<span class="glyphicon glyphicon-search small"></span>', '#', [
        'onclick' => "$('#detail-modal').modal('show');
                                    $.ajax({
                                       type: 'POST',
                                       cache: false,
                                       url: '" . Yii::$app->urlManager->createUrl(['payment/search']) . "',
                                                success: function(response) {
                                                      $('#detail-modal .modal-body').html(response);
                                                },
                                            });
                                            return false;
                                          ",
    ]);
    ?>
</div>
<br/>
<div class="table-responsive">
    <table class="table table-condensed">
        <tr>
            <th>ລຳ​ດັບ</th>
            <th>ວັນ​ທີ​ຈ່າຍ</th>
            <th>ປະເພດ​ການ​ຈ່າຍ</th>
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
                <td><?= $models->typePay->name ?></td>
                <td><?= number_format($models->amount, 2) ?></td>
                <td><?= $models->description ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທີ​ຈ່າຍ​ທັງ​ໝົດ</b></td>
            <td><b><?= number_format($amount_total, 2) ?></b></td>
            <td></td>
        </tr>
    </table>
</div>
<div class="line_bottom">ລາຍງານຈຳ​ນວນ​ເງີນ​ອາ​ທິດຜ່ານ​ມາ</div>
<br/>
<div class="table-responsive">
    <table class="table table-condensed">
        <tr>
            <th>ລຳ​ດັບ</th>
            <th>ວັນ​ທີ​ຈ່າຍ</th>
            <th>ປະເພດ​ການ​ຈ່າຍ</th>
            <th>​ຈຳ​ນວນ​ເງີນ</th>
            <th>ລາຍ​ລະ​ອຽດ</th>
        </tr>
        <?php
        $i = 0;
        $amount_total_pre = 0;
        foreach ($model_pre as $model_pres) {
            $i++;
            $amount_total_pre+=$model_pres->amount;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $model_pres->date ?></td>
                <td><?= $model_pres->typePay->name ?></td>
                <td><?= number_format($model_pres->amount, 2) ?></td>
                <td><?= $model_pres->description ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທີ​ຈ່າຍ​ທັງ​ໝົດ</b></td>
            <td><?= number_format($amount_total_pre, 2) ?></td>
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
            <th>ວັນ​ທີ​ຈ່າຍ</th>
            <th>ປະເພດ​ການ​ຈ່າຍ</th>
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
                <td><?= $models->typePay->name ?></td>
                <td><?= number_format($models->amount, 2) ?></td>
                <td><?= $models->description ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທີ​ຈ່າຍ​ທັງ​ໝົດ</b></td>
            <td><b><?= number_format($amount_total, 2) ?></b></td>
            <td></td>
        </tr>
    </table>

</div>

<div class="line_bottom">ລາຍງານຈຳ​ນວນ​ເງີນ​ເດືອນຜ່ານ​ມາ</div>
<br/>
<div class="table-responsive">
    <table class="table table-condensed">
        <tr>
            <th>ລຳ​ດັບ</th>
            <th>ວັນ​ທີ​ຈ່າຍ</th>
            <th>ປະເພດ​ການ​ຈ່າຍ</th>
            <th>​ຈຳ​ນວນ​ເງີນ</th>
            <th>ລາຍ​ລະ​ອຽດ</th>
        </tr>
        <?php
        $i = 0;
        $amount_total = 0;
        foreach ($model_m_pre as $model_m_pres) {
            $i++;
            $amount_total+=$model_m_pres->amount;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $model_m_pres->date ?></td>
                <td><?= $model_m_pres->typePay->name ?></td>
                <td><?= number_format($model_m_pres->amount, 2) ?></td>
                <td><?= $model_m_pres->description ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທີ​ຈ່າຍ​ທັງ​ໝົດ</b></td>
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
            <th>ວັນ​ທີ​ຈ່າຍ</th>
            <th>ປະເພດ​ການ​ຈ່າຍ</th>
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
                <td><?= $models->typePay->name ?></td>
                <td><?= number_format($models->amount, 2) ?></td>
                <td><?= $models->description ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="3" align="right"><b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທີ​ຈ່າຍ​ທັງ​ໝົດ</b></td>
            <td><b><?= number_format($amount_total, 2) ?></b></td>
            <td></td>
        </tr>
    </table>

</div>
<?php
Modal::begin(['clientOptions' => ['keyboard' => false], 'options' => ['id' => 'detail-modal',]])
?>
<div id='modalContent'></div>
<?php yii\bootstrap\Modal::end() ?>