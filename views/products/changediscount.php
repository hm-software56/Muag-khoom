<?php

echo yii\helpers\Html::textInput('discount', $dc, [
    'onchange' => '
                $.post( "index.php?r=products/changediscount&true=1&dc_id='.$dc_id.'&dc="+$(this).val(), function( data ) {
                  $("#dc'. $dc_id.'").html( data );
                });
            ',  
    'class' => 'form-control']);
?>