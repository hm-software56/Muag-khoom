<div class="row">
    <?php
    for ($i = 0; $i <= 100; $i++) {
        echo \barcode\barcode\BarcodeGenerator::widget(
                [
                    'elementId' => 'bar' . $i,
                    'value' => rand(100, 999) . rand(100, 999) . rand(1000, 9999) . rand(100, 999),
                    'type' => 'ean13', /* ean8, ean13, upc, std25, int25, code11, code39, code93, code128, codabar, msi, datamatrix */
                ]
        );
        ?>
        <div class="col-md-2" style="padding-bottom: 15px"><div id="bar<?= $i ?>"></div></div>
            <?php
        }
        ?>
</div>