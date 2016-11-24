<div class="row">
    <div class="col-md-12 ">
        <div class="line_bottom">
            ລາຍ​ງານ​ສີ້ນ​ຄ້າ​ທີ່​ຂາຍ​ແລ້ວ

        </div>

    </div>
    <div class="col-md-12 table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ລະ​ຫັດ</th>
                    <th>ຮູບພາບ</th>
                    <th>ຊື່​ສີ້ນ​ຄ້າ</th>
                    <th>ຈຳ​ນວນ</th>
                    <th>ລາ​ຄາ</th>
                    <th>ລວມ</th>
                    <th>ວັນ​ທີ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $array_pr = [];
                $total = 0;
                foreach ($model as $model) {
                    if (!in_array($model->products_id, $array_pr)) {
                        $array_pr[] = $model->products_id;

                        $connection = Yii::$app->getDb();
                        $command = $connection->createCommand('SELECT id from sale where products_id=' . $model->products_id . '')->queryAll();
                        $total+= $model->products->pricesale * count($command);
                        ?>
                        <tr>
                            <td><?= $model->products->code ?></td>
                            <td><a title="<?= $model->products->name ?>" rel="popover" data-img="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>"><img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->products->image ?>" class="img-rounded img-thumbnail img-responsive" width="120"/></a></td>
                            <td><?= $model->products->name ?></td>
                            <td><?= count($command) ?></td>
                            <td><?= number_format($model->products->pricesale, 2) ?></td>
                            <td><?= number_format($model->products->pricesale * count($command), 2) ?></td>
                            <td><?= $model->date ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="5" align="right">​<b>ລວມ​ຈຳ​ນວນ​ເງີນ​ທັງ​ໝົດ</b></td>
                    <td><?= number_format($total, 2) ?></td>
                    <td></td>
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