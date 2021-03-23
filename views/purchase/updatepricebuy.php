<?php

echo yii\helpers\Html::textInput('pricebuy', $pricebuy, [
    'onchange' => '
                $.post( "index.php?r=purchase/pricebuy&upid=' . $id . '&pricebuy="+$(this).val(), function( data ) {
                  $( "#qt'. $id .'" ).html( data );
                });
            ',  
    'class' => 'form-control']);
?>