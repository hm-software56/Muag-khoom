<?php

echo yii\helpers\Html::textInput('barcode', '', [
    'onchange' => '
                $.post( "index.php?r=products/chageqautity&barcode="+$(this).val(), function( data ) {
                  $( "#output" ).html( data );
                  document.getElementById("qtd").focus();

                });
            ', 'autofocus' => 'autofocus', 'placeholder' => 'ລະ​ຫັດ​ບາ​ໂຄດ', 'id' => 'search', 'class' => 'form-control']);
?>