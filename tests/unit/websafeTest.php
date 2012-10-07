<?php

namespace MischiefCollective\ColorJizz\Tests;

use MischiefCollective\ColorJizz\Formats\Hex;

class websafeTest extends \PHPUnit_Framework_TestCase
{
    public function testWebsafe()
    {
        $this->assertEquals(Hex::fromString('CD0000')->websafe()->__toString(), 'CC0000');
        $this->assertEquals(Hex::fromString('CD0100')->websafe()->__toString(), 'CC0000');
        $this->assertEquals(Hex::fromString('CD00FE')->websafe()->__toString(), 'CC00FF');
        $this->assertEquals(Hex::fromString('010000')->websafe()->__toString(), '000000');
    }
}
