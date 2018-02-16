<?php

echo yii\helpers\Html::textInput('barcode', $qautity, [
    'onchange' => '
                $.post( "index.php?r=products/qautityupdate&id=' . $id . '&qautity="+$(this).val(), function( data ) {
                  $( "#qt'. $id .'" ).html( data );
                  document.getElementById("search").focus();

                });
            ', 'autofocus' => 'autofocus', 'placeholder' => 'ລະ​ຫັດ​ບາ​ໂຄດ', 'id' => 'search', 'class' => 'form-control']);
?>