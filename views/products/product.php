<?php

use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12 ">
        <div class="line_bottom">
            ລາຍ​ງານ​ສີ້ນ​ຄ້າ​ທີຍັງ​ເຫຼືອ

        </div>
        <div style="padding: 2px; float: right">
            <?php
            echo Html::beginForm(['products/product'], 'get');
            ?>
            <table>
                <tr>
                    <td style="padding-left: 10px; padding-right: 10px;"><?= Yii::t('app', 'ສາຂາ') ?></td>
                    <td style="padding-left: 10px; padding-right: 10px;">
                        <?php
                        if (Yii::$app->user->identity->branch_id) {
                            $listData = [];
                            $branch = \app\models\Branch::find()->where(['id' => Yii::$app->user->identity->branch_id])->all();
                        } else {
                            $listData = [Yii::t('app', 'All')];
                            $branch = \app\models\Branch::find()->all();
                        }
                        foreach ($branch as $data) {
                            $listData[$data->id] = $data->branch_name;
                        }
                        echo Html::dropDownList('branch_id', Yii::$app->request->get('branch_id'), $listData, ['class' => 'form-control']);
                        ?>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary">
                            <il class="fa fa-search"></il>
                        </button>
                    </td>
                </tr>
            </table>
            <?php
            echo Html::endForm();
            ?>
        </div>
    </div>
    <div class="col-md-12 table-responsive">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th><?= Yii::t('app', 'ລ/ດ') ?></th>
                <th><?= Yii::t('app', 'ຮູບພາບ') ?></th>
                <th><?= Yii::t('app', 'ຊື່​ສີ້ນ​ຄ້າ') ?></th>
                <th><?= Yii::t('app', 'ຈຳ​ນວນ') ?></th>
                <th><?= Yii::t('app', 'ລາ​ຄາ') ?></th>
                <th><?= Yii::t('app', 'ລວມ') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            $i = 0;
            foreach ($model as $model) {
                $total += $model->pricesale * $model->qautity;
                $i++;
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><a title="<?= $model->name ?>" rel="popover"
                           data-img="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>"><img
                                    src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>"
                                    class="img-rounded img-thumbnail img-responsive" width="30"/></a></td>
                    <td><?= $model->name ?></td>
                    <td>
                        <?php
                        if (Yii::$app->request->get('branch_id')) {
                            $qtt = \app\models\Warehousebranch::find()->where(['products_id' => $model->id, 'branch_id' => Yii::$app->request->get('branch_id')])->one();
                            echo $qtt->qautity;
                        } elseif (Yii::$app->user->identity->branch_id) {
                            $qtt = \app\models\Warehousebranch::find()->where(['products_id' => $model->id, 'branch_id' => Yii::$app->user->identity->branch_id])->one();
                            echo $qtt->qautity;
                        } else {
                            echo $model->qautity;
                        }
                        ?>
                    </td>
                    <td><?= number_format($model->pricesale, 2) ?></td>
                    <td><?= number_format($model->pricesale * $model->qautity, 2) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="5" align="right">​<b><?= Yii::t('app', 'ລວມ​ຈຳ​ນວນ​ເງີນ​ທັງ​ໝົດ') ?></b></td>
                <td><b><?= number_format($total, 2) ?><b/></td>
            </tr>
            </tbody>
        </table>
        <?php
        // display pagination
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last'
        ]);
        ?>
    </div>
</div>

<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/jquery1.8.min.js"></script>
<script src="<?= Yii::$app->urlManager->baseUrl ?>/js/bootstrap2.2.1.min.js"></script>
<script>
    // Add custom JS here
    $('a[rel=popover]').popover({
        html: true,
        trigger: 'hover',
        placement: 'right',
        content: function () {
            return '<img src="' + $(this).data('img') + '" width="150" />';
        }
    });
</script>