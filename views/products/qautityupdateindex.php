<?php

echo yii\helpers\Html::textInput('barcode', $qautity, [
    'onchange' => '
                $.post( "index.php?r=products/qautityupdateindex&id=' . $id . '&qautity="+$(this).val(), function( data ) {
                  $( "#qt'. $id .'" ).html( data );
                });
            ',  
    'class' => 'form-control']);
?>