<?php

namespace MischiefCollective\ColorJizz\Tests;

use MischiefCollective\ColorJizz\Formats\Hex;

class greyscaleTest extends \PHPUnit_Framework_TestCase
{
    public function testGreyscale()
    {
        $this->assertEquals(Hex::create(0x000000)->greyscale()->hex, 0x000000);
        $this->assertEquals(Hex::create(0xFF0000)->greyscale()->hex, 0x4D4D4D);
        $this->assertEquals(Hex::create(0x00FF00)->greyscale()->hex, 0x969696);
        $this->assertEquals(Hex::create(0x0000FF)->greyscale()->hex, 0x1C1C1C);
    }
}
