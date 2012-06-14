<?php

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

class HSV extends ColorJizz
{

    public $h;
    public $s;
    public $v;

    public function __construct($h, $s, $v)
    {
        $this->toSelf = "toHSV";
        $this->h = $h;
        $this->s = $s;
        $this->v = $v;
    }

    public function toHex()
    {
        return $this->toRGB()->toHex();
    }

    public function toRGB()
    {
        $h = $this->h / 360;
        $s = $this->s / 100;
        $v = $this->v / 100;
        if ($s == 0) {
            $r = $v * 255;
            $g = $v * 255;
            $b = $v * 255;
        } else {
            $var_h = $h * 6;
            $var_i = floor($var_h);
            $var_1 = $v * (1 - $s);
            $var_2 = $v * (1 - $s * ($var_h - $var_i));
            $var_3 = $v * (1 - $s * (1 - ($var_h - $var_i)));

            if ($var_i == 0) {
                $var_r = $v;
                $var_g = $var_3;
                $var_b = $var_1;
            } else if ($var_i == 1) {
                $var_r = $var_2;
                $var_g = $v;
                $var_b = $var_1;
            } else if ($var_i == 2) {
                $var_r = $var_1;
                $var_g = $v;
                $var_b = $var_3;
            } else if ($var_i == 3) {
                $var_r = $var_1;
                $var_g = $var_2;
                $var_b = $v;
            } else if ($var_i == 4) {
                $var_r = $var_3;
                $var_g = $var_1;
                $var_b = $v;
            } else {
                $var_r = $v;
                $var_g = $var_1;
                $var_b = $var_2;
            }

            $r = $var_r * 255;
            $g = $var_g * 255;
            $b = $var_b * 255;
        }
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
        return $this;
    }

    public function toCMY()
    {
        return $this->toRGB()->toCMY();
    }

    public function toCMYK()
    {
        return $this->toCMY()->toCMYK();
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
        return sprintf('%s,%s,%s', $this->h, $this->s, $this->v);
    }

}
