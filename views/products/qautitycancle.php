<?php

echo yii\helpers\Html::textInput('barcode', $qautity, [
    'onchange' => '
                $.post( "index.php?r=products/qautitycancle&true=1&idp=' . $idp . '&i=' . $i . '&inv_id='.$inv_id.'&qautity="+$(this).val(), function( data ) {
                  $( "#qt'. $i .'" ).html( data );
                });
            ',  
    'class' => 'form-control']);
?>