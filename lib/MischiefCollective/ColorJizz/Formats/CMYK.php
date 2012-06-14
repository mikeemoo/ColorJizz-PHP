<?php

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

class CMYK extends ColorJizz
{

    public $c;
    public $m;
    public $y;
    public $k;

    public function __construct($c, $m, $y, $k)
    {
        $this->toSelf = "toCMYK";
        $this->c = $c;
        $this->m = $m;
        $this->y = $y;
        $this->k = $k;
    }

    public static function create($c, $m, $y, $k)
    {
        return new CMYK($c, $m, $y, $k);
    }

    public function toHex()
    {
        return $this->toRGB()->toHex();
    }

    public function toRGB()
    {
        return $this->toCMY()->toRGB();
    }

    public function toXYZ()
    {
        return $this->toRGB()->toXYZ();
    }

    public function toYxy()
    {
        return $this->toXYZ()->toYxy();
    }

    public function toHSV()
    {
        return $this->toRGB()->toHSV();
    }

    public function toCMY()
    {
        $C = ($this->c * (1 - $this->k) + $this->k);
        $M = ($this->m * (1 - $this->k) + $this->k);
        $Y = ($this->y * (1 - $this->k) + $this->k);
        return new CMY($C, $M, $Y);
    }

    public function toCMYK()
    {
        return $this;
    }

    public function toCIELab()
    {
        return $this->toRGB()->toCIELab();
    }

    public function toCIELCh()
    {
        return $this->toCIELab()->toCIELCh();
    }

    public function __toString()
    {
        return sprintf('%s,%s,%s,%s', $this->c, $this->m, $this->y, $this->k);
    }

}