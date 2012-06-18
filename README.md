#Getting started:

ColorJizz-PHP uses the PSR-0 standards for namespaces, so there should be no trouble using with frameworks like Symfony 2.

###Autoloading

An autoloader class is provided for when loading ColorJizz yourself.

First, include the autoloader and call the static register() function.


```php
<?php
require_once 'path/to/colorjizz/lib/MischiefCollective/ColorJizz/Autoloader.php';
MischiefCollective\ColorJizz\Autoloader::register();
?>
```

Now all ColorJizz classes will be automatically loaded in.

###Converting between formats

ColorJizz can convert to and from any of the supported color formats:

```php
<?php
use MischiefCollective\ColorJizz\Formats\Hex;

$red_hex = new Hex(0xFF0000);
$red_cmyk = $hex->toCMYK();

echo get_class($red_cmyk); // MischiefCollective\ColorJizz\Formats\CMYK
echo $red_cmyk; // 0,1,1,0
?>
```

Any color manipulation or conversion will return a new instance of a color class, therefore your original color objects remains intact.

Color manipulation can be chained together:

```php
<?php
use MischiefCollective\ColorJizz\Formats\Hex;

echo Hex::fromString('red')->hue(-20)->greyscale(); // 555555
?>
```

Any color manipulation will always return the color in the same format unless you're specifically converting the format. For example:

```php
<?php
use MischiefCollective\ColorJizz\Formats\RGB;

$red = new RGB(255, 0, 0);
echo get_class($red->hue(-20)->saturation(2)); // MischiefCollective\ColorJizz\Formats\RGB
?>
```

###Supported formats:

```php
<?php
new RGB(r, g, b);
new CMY(c, m, y);
new CMYK(c, m, y, k);
new Hex(0x000000);
new CIELab(l, a, b);
new CIELCh(l, c, h);
new XYZ(x, y, z);
new Yxy(Y, x, y);
```

###Conversion functions:

```php
<?php
->toRGB();
->toCMY();
->toCMYK();
->toHex();
->toCIELab();
->toCIELCh();
->toXYZ();
->toYxy();
```


