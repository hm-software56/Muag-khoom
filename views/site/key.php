<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div id="modal_key" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <?php $form = ActiveForm::begin(['action' =>['site/key']]); ?>
        <?php
            if (Yii::$app->session->hasFlash('success_key')) {
        ?>
            <h2 style="color:green"><?=Yii::$app->session->getFlash('success_key')?></h2>
        <?php
            }else{
        ?>
                <div class="row">
                    <div class="col-md-12" align="center">
                        <?php
                            echo Html::textInput('key', '', ['autocomplete' => "on", 'required'=>'required', 'placeholder' => Yii::t('app','Input key'), 'class' => 'fadeIn second ']);
                        ?>
                    </div>
                    <div class="col-md-12" align="center">
                    <button type="submit" class="btn btn-primary"><?=Yii::t('app','Activate')?></button>
                    </div>
                    <div class="col-md-12">
                        <?php
                        if (Yii::$app->session->hasFlash('error_key')) {
                        ?>
                        <h5 style="color:red" align="center"><?=Yii::$app->session->getFlash('error_key')?></h5>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                
        <?php
            }
        ?>
            </div>
        </div>
            <?php ActiveForm::end(); ?>

</div>