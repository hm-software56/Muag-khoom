<div class="row">
    <div class="col-md-12 ">
        <div class="line_bottom">
            ລາຍ​ງານ​ສີ້ນ​ຄ້າ​ທີຍັງ​ເຫຼືອ

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
                $total = 0;
                foreach ($model as $model) {
                    $total+=$model->pricesale * $model->qautity;
                    ?>
                    <tr>
                        <td><?= $model->code ?></td>
                        <td><a title="<?= $model->name ?>" rel="popover" data-img="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>"><img src="<?= Yii::$app->urlManager->baseUrl ?>/images/thume/<?= $model->image ?>" class="img-rounded img-thumbnail img-responsive" width="150"/></a></td>
                        <td><?= $model->name ?></td>
                        <td><?= $model->qautity ?></td>
                        <td><?= number_format($model->pricesale, 2) ?></td>
                        <td><?= number_format($model->pricesale * $model->qautity, 2) ?></td>
                        <td><?= $model->date ?></td>
                    </tr>
                    <?php
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