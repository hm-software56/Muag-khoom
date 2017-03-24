<?php

if (isset($discount)) {
    echo yii\helpers\Html::a("<b>" . number_format(\Yii::$app->session['discount'], 2) . "</b>", '#', [
        'onclick' => "
                $.ajax({
                type     :'POST',
                cache    : false,
                url  : 'index.php?r=products/discount',
                success  : function(response) {
                $('#dsc').html(response);
                document.getElementById('dsc').focus();
                }
                });return false;",
        'style' => "color:red;"
    ]);
} else {
    echo yii\helpers\Html::textInput('discount', "", [
        'onchange' => '
                $.post( "index.php?r=products/discount&dsc="+$(this).val(), function( data ) {
                  $( "#dsc" ).html( data );
                  document.getElementById("search").focus();

                });
            ', 'autofocus' => 'autofocus', 'placeholder' => 'ສ່ວນຫຼຸດ', 'id' => 'search', 'class' => 'form-control']);
}
?>