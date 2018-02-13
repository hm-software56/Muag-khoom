<?php

echo yii\helpers\Html::textInput('qautity_new', $qautity_old, ['oninput'=>"this.value=this.value.replace(/[^\d]/,'')",
    'onchange' => '
                $.post( "index.php?r=products/chageqautity&id='.$product_id.'&qautity_new="+$(this).val(), function( data ) {
                  $( "#output" ).html( data );
                  document.getElementById("search").focus(); 

                });
            ', 'autofocus' => 'autofocus','onfocus'=>"var temp_value=this.value; this.value=''; this.value=temp_value", 'placeholder' => '', 'id' => 'qtdf'.$product_id.'', 'style' => 'width:40px']);
?>