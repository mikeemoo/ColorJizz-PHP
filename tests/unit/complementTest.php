<?php

namespace MischiefCollective\ColorJizz\Tests;

use MischiefCollective\ColorJizz\Formats\Hex;

class complementTest extends \PHPUnit_Framework_TestCase
{
    public function testWebsafe()
    {
        $this->assertEquals(Hex::fromString('FFFFFF')->complement()->__toString(), 'FFFFFF');
        $this->assertEquals(Hex::fromString('FF0000')->complement()->__toString(), '00A1F3');
    }
}
