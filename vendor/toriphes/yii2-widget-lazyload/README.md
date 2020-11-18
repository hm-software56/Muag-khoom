yii2-widget-lazyload
====================
[![Latest Stable Version](https://poser.pugx.org/toriphes/yii2-console-runner/v/stable)](https://packagist.org/packages/toriphes/yii2-widget-lazyload) 
[![Total Downloads](https://poser.pugx.org/toriphes/yii2-widget-lazyload/downloads)](https://packagist.org/packages/toriphes/yii2-widget-lazyload) 
[![Latest Unstable Version](https://poser.pugx.org/toriphes/yii2-widget-lazyload/v/unstable)](https://packagist.org/packages/toriphes/yii2-widget-lazyload) 
[![License](https://poser.pugx.org/toriphes/yii2-widget-lazyload/license)](https://packagist.org/packages/toriphes/yii2-widget-lazyload)

Wrapper of [lazy loading](http://www.appelsiini.net/projects/lazyload ) jquery library. 

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist toriphes/yii2-widget-lazyload "*"
```

or add

```
"toriphes/yii2-widget-lazyload": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
use toriphes\lazyload\LazyLoad;

echo LazyLoad::widget(['src' => 'url/to/your/image.jpg']);

//enable fallback for non JavaScript user
echo LazyLoad::widget(['src' => 'url/to/your/image.jpg', 'fallback' => true]);
```