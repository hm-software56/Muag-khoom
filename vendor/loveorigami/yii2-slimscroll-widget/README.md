SlimScroll widget for Yii 2
==============================

## Description

SlimScroll is a small (4.6KB) jQuery plugin that transforms any div into a scrollable area with a nice scrollbar - similar to the one Facebook and Google started using in their products recently. slimScroll doesn't occupy any visual space as it only appears on a user initiated mouse-over. User can drag the scrollbar or use mouse-wheel to change the scroll value.
For more information please visit [SlimScroll](http://rocha.la/jQuery-slimScroll) 

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). 

To install, either run

```
$ php composer.phar require loveorigami/yii2-slimscroll-widget "*"
```
or add

```
"loveorigami/yii2-slimscroll-widget": "*"
```

to the ```require``` section of your `composer.json` file.

## Usage

```php
use lo\widgets\SlimScroll;

<?= SlimScroll::widget([
	'options'=>[
		'height'=>'250px'
	]
]); 
?>
<p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam rhoncus, felis interdum condimentum consectetur, nisl libero elementum eros, vehicula congue lacus eros non diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus mauris lorem, lacinia id tempus non, imperdiet et leo. Cras sit amet erat sit amet lacus egestas placerat. Aenean ultricies ultrices mauris ac congue
</p>
<?= SlimScroll::end(); ?>

```

## Default options

```php
    private static $default=[
        'height' => '350px',
        
        //'width'=> '250px',
        //'size' => '10px',
        //'position' => 'left',
        //'color' => '#ffcc00',
        //'distance' => '20px',
        //'start' => '$('#child_image_element')',

        'alwaysVisible' => true,
        'railVisible' => true,
        'railColor' => '#222',
        'railOpacity' => '0.3',
        'wheelStep' => 10,
        'allowPageScroll' => true,
        'disableFadeOut' => false
    ];
```

## License

**loveorigami/yii2-slimscroll-widget** is released under the MIT License. See the bundled `LICENSE.md` for details.