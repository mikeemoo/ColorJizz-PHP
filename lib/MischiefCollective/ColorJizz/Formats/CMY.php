<?php

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

class CMY extends ColorJizz
{

    public $c;
    public $m;
    public $y;

    public function __construct($c, $m, $y)
    {
        $this->toSelf = "toCMY";
        $this->c = $c;
        $this->m = $m;
        $this->y = $y;
    }

    public static function create($c, $m, $y)
    {
        return new CMY($c, $m, $y);
    }

    public function toHex()
    {
        return $this->toRGB()->toHex();
    }

    public function toRGB()
    {
        $r = (1 - $this->c) * 255;
        $g = (1 - $this->m) * 255;
        $b = (1 - $this->y) * 255;
        return new RGB($r, $g, $b);
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
        return $this;
    }

    public function toCMYK()
    {
        $var_K = 1;
        $C = $this->c;
        $M = $this->m;
        $Y = $this->y;
        if ($C < $var_K)
            $var_K = $C;
        if ($M < $var_K)
            $var_K = $M;
        if ($Y < $var_K)
            $var_K = $Y;
        if ($var_K == 1) {
            $C = 0;
            $M = 0;
            $Y = 0;
        } else {
            $C = ($C - $var_K) / (1 - $var_K);
            $M = ($M - $var_K) / (1 - $var_K);
            $Y = ($Y - $var_K) / (1 - $var_K);
        }

        $K = $var_K;

        return new CMYK($C, $M, $Y, $K);
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
        return sprintf('%s,%s,%s', $this->c, $this->m, $this->y);
    }

}
