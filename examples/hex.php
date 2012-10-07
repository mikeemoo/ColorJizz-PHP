<?php

require_once '../src/MischiefCollective/ColorJizz/Autoloader.php';
MischiefCollective\ColorJizz\Autoloader::register();

use MischiefCollective\ColorJizz\Formats\Hex;

echo Hex::create(0x00096A)->toCIELCh()->toHex()->hue(230);