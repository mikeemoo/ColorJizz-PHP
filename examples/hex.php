<?php

require_once '../lib/MischiefCollective/ColorJizz/Autoloader.php';
MischiefCollective\ColorJizz\Autoloader::register();

use MischiefCollective\ColorJizz\Formats\Hex;

echo Hex::create(0x00096A)->toCIELCh()->toHex();
