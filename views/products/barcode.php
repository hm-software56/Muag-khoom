<?php
if (Yii::$app->session->hasFlash('su')) {
    echo kartik\alert\Alert::widget([
        'type' => kartik\alert\Alert::TYPE_SUCCESS,
        'title' => Yii::$app->session->getFlash('action'),
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('su'),
        'showSeparator' => false,
        'delay' => 500
    ]);
}

if (Yii::$app->session->hasFlash('error')) {
    echo kartik\alert\Alert::widget([
        'type' => kartik\alert\Alert::TYPE_DANGER,
        'title' => Yii::$app->session->getFlash('action'),
        'icon' => 'glyphicon glyphicon-ok-sign',
        'body' => Yii::$app->session->getFlash('error'),
        'showSeparator' => false,
        'delay' => 2000
    ]);
}
?>
<table class="table table-striped">
    <tr>
        <th>ລຳ​ດັບ</th>
        <th>​<div class="col-md-5 col-sm-5">ລະ​ຫັດ​ບາ​ໂຄດ</div>
    <div class="col-md-7 col-sm-7"><?php
        if (count($models)<1) {
            echo yii\helpers\Html::textInput('barcode', '', [
                'onchange' => '
                $.post( "index.php?r=products/setbarcode&pro_id=' . \Yii::$app->session['pro_id'] . '&barcode="+$(this).val(), function( data ) {
                  $( "#barcode" ).html( data );
                  document.getElementById("search").focus();

                });
            ', 'autofocus' => 'autofocus', 'placeholder' => 'ລະ​ຫັດ​ບາ​ໂຄດ', 'id' => 'search', 'class' => 'form-control']);
        }
        ?></div>
</th>
<td></td>
</tr>
<?php
$i = 0;
foreach ($models as $model) {
    $i++;
    ?>
    
    <tr>
        <td><?= $i ?></td>
        <td>
        <img id="barcode<?= $i ?>"></div><?= $model->barcode ?></td>

        <td>
            <?php
            echo yii\helpers\Html::a('<span class="glyphicon glyphicon-remove" style="color: red;"></span>', '#', [
                'onclick' => "
                        $.ajax({
                       type     :'POST',
                       cache    : false,
                       url  : 'index.php?r=products/setbarcode&pro_id=" . $model->products_id . "&barcode=" . $model->barcode . "&del=true',
                       success  : function(response) {
                           $('#barcode').html(response);
                           document.getElementById('search').focus();
                       }
                       });return false;",
            ]);
            ?>
        </td>
    </tr>
    <?php
}
?>
</table>