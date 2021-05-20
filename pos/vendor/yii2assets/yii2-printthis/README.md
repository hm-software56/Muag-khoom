PrintThis for Yii Framework 2
---
Install
-----
composer require yii2assets/yii2-printthis "^1.0"
or add this line to composer.json
"yii2assets/yii2-printthis": "^1.0"

Usage
-----
To use this widget, insert the following code into a view file:
```php
<?php
echo PrintThis::widget([
	'htmlOptions' => [
		'id' => 'PrintThis',
		'btnClass' => 'btn btn-info',
		'btnId' => 'btnPrintThis',
		'btnText' => 'พิมพ์หน้านี้',
		'btnIcon' => 'fa fa-print'
	],
	'options' => [
		'debug' => false,
		'importCSS' => true,
		'importStyle' => false,
		'loadCSS' => "path/to/my.css",
		'pageTitle' => "",
		'removeInline' => false,
		'printDelay' => 333,
		'header' => null,
		'formValues' => true,
	]
]);
?>
```
in view file for print area
```html
<div id="PrintThis">
Your Html code here
</div>
```

you can add css for disable link display
```css
@media print {
    .noprint {display:none !important;}
    a:link:after, a:visited:after {  
      display: none;
      content: "";    
    }
}
```
