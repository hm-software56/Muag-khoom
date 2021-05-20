<style>
    .pdfobject-container { height: 500px;}
    .pdfobject { border: 1px solid #666; }
</style>
<div id="example1"></div>
<script src="<?= Yii::$app->urlManager->baseUrl ?>/pdf/pdfobject.js"></script>
<script>PDFObject.embed("/pdf/sample-3pp.pdf", "#example1");</script>