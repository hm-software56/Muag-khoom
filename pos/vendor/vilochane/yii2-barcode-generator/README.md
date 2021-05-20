barcode-generator-8-types
=========================
This extension based on "Simple jQuery Based Barcode Generator" Wrapper for BarCode Coder Library (BCC Library Version 2.0) by DEMONTE Jean-Baptiste, HOUREZ Jonathan.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require vilochane/yii2-barcode-generator: dev-master
```

or add

```
"vilochane/yii2-barcode-generator": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \barcode\barcode\BarcodeGenerator::widget(); ?>```