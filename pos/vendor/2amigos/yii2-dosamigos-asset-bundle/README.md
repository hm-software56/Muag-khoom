Asset Bundle Component for Yii2
===============================

Includes an asset bundle component which will register assets that are shared among projects that includes certain
extensions created by [2amigOS! Consulting Group LLC](http://2amigos.us). Currently, this asset bundle provides:

* dosamigos javascript root namespace

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require "2amigos/yii2-dosamigos-asset-bundle" "*"
```
or add

```json
"2amigos/yii2-dosamigos-asset-bundle" : "*"
```

to the require section of your application's `composer.json` file.

Usage
-----

```php
use dosamigos\assets\DosAmigosAsset;

DosAmigosAsset::register($this);

```

If its a requirement of an extension created by [2amigOS!](http://2amigos.us) it will be automatically registered.

Further Information
-------------------
Please, check the [Yii2](https://github.com/yiisoft/yii2/blob/master/docs/guide/structure-assets.md)
documentation about assets for further information about its integration.


> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)  
<i>Web development has never been so fun!</i>  
[www.2amigos.us](http://www.2amigos.us)