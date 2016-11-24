


<div class="row">
    <div class="col-md-12 ">
        <div class="line_bottom">
            ລາຍ​ງານ​ສີ້ນ​ຄ້າ​ຂາຍ​ແລ້ວ ແລະ ຍັງ​ເຫຼືອ

        </div>

    </div>
    <div class="col-md-12 table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ລະ​ຫັດ</th>
                    <th>ຮູບພາບ</th>
                    <th>ຊື່​ສີ້ນ​ຄ້າ</th>
                    <th>ຈນທັງ​ໝົດ</th>
                    <th>ຈຳ​ນວນຍັງ</th>
                    <th>ຈຳ​ນວນຂາຍ​</th>
                    <th>ລາ​ຄາຊື້</th>
                    <th>ລາ​ຄາຂາຍ</th>
                    <th>ລວມຊື້</th>
                    <th>ລວມຂາຍ</th>
                    <th>ກຳ​ລາຍ​ທີ່​ຂາຍ​ແລ້ວ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_not = 0;
                $total_sale = 0;
                $total_r = 0;
                foreach ($model as $model) {
                    $total_not+=$model->pricebuy * $model->qautity;

                    $connection = Yii::$app->getDb();
                    $command = $connection->createCommand('SELECT id from sale where products_id=' . $model->id . '')->queryAll();
                    $total_sale+=$model->pricesale * count($command);
                    $total_r+= ($model->pricesale * count($command)) - ($model->pricebuy * count($command));
                    ?>
                    <tr>
                        <td><?= $model->code ?></td>
                        <td><a title="<?= $model->name ?>" rel="popover" data-img="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>"><img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="img-rounded img-thumbnail img-responsive" width="150"/></a></td>
                        <td><?= $model->name ?></td>
                        <td><b><?= $model->qautity + count($command) ?></b></td>
                        <td class="text-red"><?= $model->qautity ?></td>
                        <td class="text-success"><?= count($command); ?></td>
                        <td class="text-red"><?= number_format($model->pricebuy, 2) ?></td>
                        <td class="text-success"><?= number_format($model->pricesale, 2) ?></td>
                        <td class="text-red"><?= number_format($model->pricebuy * $model->qautity, 2) ?></td>
                        <td class="text-success"><?= number_format($model->pricesale * count($command), 2) ?></td>
                        <td class="text-success"><b><?= number_format(($model->pricesale * count($command)) - ($model->pricebuy * count($command)), 2) ?></b></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="8" align="right">​<b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທັງ​ໝົດ</b></td>
                    <td><b><?= number_format($total_not, 2) ?></b></td>
                    <td><b><?= number_format($total_sale, 2) ?></b></td>
                    <td class="bg-aqua"><b><?= number_format($total_r, 2) ?></b></td>
                </tr>
            </tbody>
        </table>
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
