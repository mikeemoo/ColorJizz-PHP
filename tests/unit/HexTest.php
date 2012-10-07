<?php

namespace MischiefCollective\ColorJizz\Tests;

use MischiefCollective\ColorJizz\Formats\Hex,
    MischiefCollective\ColorJizz\Exceptions\InvalidArgumentException;

class HexTest extends \PHPUnit_Framework_TestCase
{

    public function testFromString()
    {

      $this->assertEquals(0xDB09E4, Hex::fromString('DB09e4')->hex);
      $this->assertEquals(0x487453, Hex::fromString('487453')->hex);
      $this->assertEquals(0x36F6F6, Hex::fromString('36f6F6')->hex);
      $this->assertEquals(0xFE5006, Hex::fromString('fE5006')->hex);
      $this->assertEquals(0x41EB55, Hex::fromString('41eb55')->hex);
      $this->assertEquals(0x686639, Hex::fromString('686639')->hex);
      $this->assertEquals(0x222B65, Hex::fromString('222B65')->hex);

      $this->assertEquals(0x000000, Hex::fromString('000000')->hex);
      $this->assertEquals(0xFFFFFF, Hex::fromString('FfFfFf')->hex);

      $this->assertEquals(0x000000, Hex::fromString('#000000')->hex);
      $this->assertEquals(0xFFFFFF, Hex::fromString('#fFf')->hex);

      $this->assertEquals(0x000000, Hex::fromString('black')->hex);
      $this->assertEquals(0x000000, Hex::fromString('BLAck')->hex);
      $this->assertEquals(0xFF0000, Hex::fromString('red')->hex);

    }

    public function testFromStringExceptions()
    {
      $terms = array(
        'broken',
        '#0FW',
        'saf0sddasd',
        '0assaaaa',
        'black-',
      );

      foreach ($terms as $term) {
        $exception = false;
        try {
          Hex::fromString($term);
        } catch (InvalidArgumentException $exception) {
          $exception = true;
        }
        if (!$exception) {
          $this->fail(sprintf('No exception thrown using fromString(\'%s\')', $term));
        }
      }
    }

    public function testToString()
    {
      $this->assertEquals('DACDD3', Hex::create(0xDACDD3)->__toString());
      $this->assertEquals('8207D7', Hex::create(0x8207D7)->__toString());
      $this->assertEquals('1F66D9', Hex::create(0x1F66D9)->__toString());
      $this->assertEquals('FEE158', Hex::create(0xFEE158)->__toString());
      $this->assertEquals('313258', Hex::create(0x313258)->__toString());
      $this->assertEquals('572F84', Hex::create(0x572F84)->__toString());
      $this->assertEquals('6474C2', Hex::create(0x6474C2)->__toString());
      $this->assertEquals('E406AE', Hex::create(0xE406AE)->__toString());
      $this->assertEquals('EB613D', Hex::create(0xEB613D)->__toString());

      $this->assertEquals('FFFFFF', Hex::create(0xFFFFFF)->__toString());
      $this->assertEquals('000000', Hex::create(0x000000)->__toString());
    }


    public function testToRGBAndBack()
    {
      for ($i=0; $i<=0xFFFFFF; $i+=0x0004B5)
      {
        $this->assertEquals($i, Hex::create($i)->toRGB()->toHex()->hex);
      }
    }

    public function testToXYZAndBack()
    {
      for ($i=0; $i<=0xFFFFFF; $i+=0x0004B5)
      {
        $this->assertEquals($i, Hex::create($i)->toXYZ()->toHex()->hex);
      }
    }

    public function testToCMYAndBack()
    {
      for ($i=0; $i<=0xFFFFFF; $i+=0x0004B5)
      {
        $this->assertEquals($i, Hex::create($i)->toCMY()->toHex()->hex);
      }
    }

    public function testToCMYKAndBack()
    {
      for ($i=0; $i<=0xFFFFFF; $i+=0x0004B5)
      {
        $this->assertEquals($i, Hex::create($i)->toCMYK()->toHex()->hex);
      }
    }

    public function testToYxyAndBack()
    {
      for ($i=0; $i<=0xFFFFFF; $i+=0x0004B5)
      {
        $this->assertEquals($i, Hex::create($i)->toYxy()->toHex()->hex);
      }
    }

    public function testToCIELabAndBack()
    {
      for ($i=0; $i<=0xFFFFFF; $i+=0x0004B5)
      {
        $this->assertEquals($i, Hex::create($i)->toCIELab()->toHex()->hex);
      }
    }

    public function testToCIELChAndBack()
    {
      for ($i=0; $i<=0xFFFFFF; $i+=0x0004B5)
      {
        $this->assertEquals($i, Hex::create($i)->toCIELCh()->toHex()->hex);
      }
    }

    public function testToHSVAndBack()
    {
      for ($i=0; $i<=0xFFFFFF; $i+=0x0004B5)
      {
        $this->assertEquals($i, Hex::create($i)->toHSV()->toHex()->hex);
      }
    }
}