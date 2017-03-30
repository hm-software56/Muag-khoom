<?php
echo \yii2assets\printthis\PrintThis::widget([
    'htmlOptions' => [
        'id' => 'print',
        'btnClass' => 'btn bg-red',
        'btnId' => 'btnPrintThis',
        'btnText' => 'ພີມ​ບາ​ໂຄດ',
        'btnIcon' => 'glyphicon glyphicon-print'
    ],
    'options' => [
        'debug' => false,
        'importCSS' => true,
        'importStyle' => false,
        'loadCSS' => "path/to/my.css",
        'pageTitle' => "",
        'removeInline' => true,
        'printDelay' => 333,
        'header' => null,
        'formValues' => true,
    ]
]);
?>
<hr/>
<div  id="print"  align="center">
    <?php
    $barcodes = \app\models\Barcode::find()->where(['status' => 1])->all();
    $i = 0;
    foreach ($barcodes as $barcode) {
        $i++;
        ?>
        <img id="barcode<?= $i ?>">

        <?php
    }
    ?>
</div>