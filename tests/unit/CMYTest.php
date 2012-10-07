<?php

namespace MischiefCollective\ColorJizz\Tests;

use MischiefCollective\ColorJizz\Formats\CMY;

class CMYTest extends \PHPUnit_Framework_TestCase
{
    const DELTA = 0.002;


    public function testToHexAndBack()
    {
        for ($c = 0; $c <= 1; $c += 0.1) {
            for ($m = 0; $m <= 1; $m += 0.1) {
                for ($y = 0; $y <= 1; $y += 0.1) {
                    $cmy = CMY::create($c, $m, $y)->toHex()->toCMY();
                    $this->assertEquals($c, $cmy->getCyan(), null, self::DELTA);
                    $this->assertEquals($m, $cmy->getMagenta(), null, self::DELTA);
                    $this->assertEquals($y, $cmy->getYellow(), null, self::DELTA);
                }
            }
        }
    }

    public function testToRGBAndBack()
    {
        for ($c = 0; $c <= 1; $c += 0.1) {
            for ($m = 0; $m <= 1; $m += 0.1) {
                for ($y = 0; $y <= 1; $y += 0.1) {
                    $cmy = CMY::create($c, $m, $y)->toRGB()->toCMY();
                    $this->assertEquals($c, $cmy->getCyan(), null, self::DELTA);
                    $this->assertEquals($m, $cmy->getMagenta(), null, self::DELTA);
                    $this->assertEquals($y, $cmy->getYellow(), null, self::DELTA);
                }
            }
        }
    }

    public function testToXYZAndBack()
    {
        for ($c = 0; $c <= 1; $c += 0.1) {
            for ($m = 0; $m <= 1; $m += 0.1) {
                for ($y = 0; $y <= 1; $y += 0.1) {
                    $cmy = CMY::create($c, $m, $y)->toXYZ()->toCMY();
                    $this->assertEquals($c, $cmy->getCyan(), null, self::DELTA);
                    $this->assertEquals($m, $cmy->getMagenta(), null, self::DELTA);
                    $this->assertEquals($y, $cmy->getYellow(), null, self::DELTA);
                }
            }
        }
    }


    public function testToCMYKAndBack()
    {
        for ($c = 0; $c <= 1; $c += 0.1) {
            for ($m = 0; $m <= 1; $m += 0.1) {
                for ($y = 0; $y <= 1; $y += 0.1) {
                    $cmy = CMY::create($c, $m, $y)->toCMYK()->toCMY();
                    $this->assertEquals($c, $cmy->getCyan(), null, self::DELTA);
                    $this->assertEquals($m, $cmy->getMagenta(), null, self::DELTA);
                    $this->assertEquals($y, $cmy->getYellow(), null, self::DELTA);
                }
            }
        }
    }

    public function testToYxyAndBack()
    {
        for ($c = 0; $c <= 1; $c += 0.1) {
            for ($m = 0; $m <= 1; $m += 0.1) {
                for ($y = 0; $y <= 1; $y += 0.1) {
                    $cmy = CMY::create($c, $m, $y)->toYxy()->toCMY();
                    $this->assertEquals($c, $cmy->getCyan(), null, self::DELTA);
                    $this->assertEquals($m, $cmy->getMagenta(), null, self::DELTA);
                    $this->assertEquals($y, $cmy->getYellow(), null, self::DELTA);
                }
            }
        }
    }

    public function testToCIELabAndBack()
    {
        for ($c = 0; $c <= 1; $c += 0.1) {
            for ($m = 0; $m <= 1; $m += 0.1) {
                for ($y = 0; $y <= 1; $y += 0.1) {
                    $cmy = CMY::create($c, $m, $y)->toCIELab()->toCMY();
                    $this->assertEquals($c, $cmy->getCyan(), null, self::DELTA);
                    $this->assertEquals($m, $cmy->getMagenta(), null, self::DELTA);
                    $this->assertEquals($y, $cmy->getYellow(), null, self::DELTA);
                }
            }
        }
    }

    public function testToCIELChAndBack()
    {
        for ($c = 0; $c <= 1; $c += 0.1) {
            for ($m = 0; $m <= 1; $m += 0.1) {
                for ($y = 0; $y <= 1; $y += 0.1) {
                    $cmy = CMY::create($c, $m, $y)->toCIELCh()->toCMY();
                    $this->assertEquals($c, $cmy->getCyan(), null, self::DELTA);
                    $this->assertEquals($m, $cmy->getMagenta(), null, self::DELTA);
                    $this->assertEquals($y, $cmy->getYellow(), null, self::DELTA);
                }
            }
        }
    }

    public function testToHSVAndBack()
    {
        for ($c = 0; $c <= 1; $c += 0.1) {
            for ($m = 0; $m <= 1; $m += 0.1) {
                for ($y = 0; $y <= 1; $y += 0.1) {
                    $cmy = CMY::create($c, $m, $y)->toHSV()->toCMY();
                    $this->assertEquals($c, $cmy->getCyan(), null, self::DELTA);
                    $this->assertEquals($m, $cmy->getMagenta(), null, self::DELTA);
                    $this->assertEquals($y, $cmy->getYellow(), null, self::DELTA);
                }
            }
        }
    }
}

?>