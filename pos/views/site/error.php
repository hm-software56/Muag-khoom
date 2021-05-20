<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$title=Yii::t('app','ຄໍາເຕືອນ');
$detail=Yii::t('app','ທ່ານບໍມີສິດເຂົ້າຫາໜ້ານີ້.!');
$script = <<< JS
    Swal.fire({
    title:$title,
    icon: 'warning',
    html:$detail,
    showDenyButton:false,
    showConfirmButton: false,
});
JS;
$this->registerJs($script);
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>
