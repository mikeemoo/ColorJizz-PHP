<?php

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

class CIELab extends ColorJizz
{

    public $l;
    public $a;
    public $b;

    public function __construct($l, $a, $b)
    {
        $this->toSelf = "toCIELab";
        $this->l = $l; //$this->roundDec($l, 3);
        $this->a = $a; //$this->roundDec($a, 3);
        $this->b = $b; //$this->roundDec($b, 3);
    }

    public static function create($l, $a, $b)
    {
        return new CIELab($l, $a, $b);
    }

    public function toHex()
    {
        return $this->toRGB()->toHex();
    }

    public function toRGB()
    {
        return $this->toXYZ()->toRGB();
    }

    public function toXYZ()
    {
        $ref_X = 95.047;
        $ref_Y = 100.000;
        $ref_Z = 108.883;

        $var_Y = ($this->l + 16) / 116;
        $var_X = $this->a / 500 + $var_Y;
        $var_Z = $var_Y - $this->b / 200;

        if (pow($var_Y, 3) > 0.008856) {
            $var_Y = pow($var_Y, 3);
        } else {
            $var_Y = ($var_Y - 16 / 116) / 7.787;
        }
        if (pow($var_X, 3) > 0.008856) {
            $var_X = pow($var_X, 3);
        } else {
            $var_X = ($var_X - 16 / 116) / 7.787;
        }
        if (pow($var_Z, 3) > 0.008856) {
            $var_Z = pow($var_Z, 3);
        } else {
            $var_Z = ($var_Z - 16 / 116) / 7.787;
        }
        $x = $ref_X * $var_X;
        $y = $ref_Y * $var_Y;
        $z = $ref_Z * $var_Z;
        return new XYZ($x, $y, $z);
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
        return $this->toRGB()->toCMY();
    }

    public function toCMYK()
    {
        return $this->toCMY()->toCMYK();
    }

    public function toCIELab()
    {
        return $this;
    }

    public function toCIELCh()
    {
        $var_H = atan2($this->b, $this->a);

        if ($var_H > 0) {
            $var_H = ($var_H / pi()) * 180;
        } else {
            $var_H = 360 - (abs($var_H) / pi()) * 180;
        }

        $l = $this->l;
        $c = sqrt(pow($this->a, 2) + pow($this->b, 2));
        $h = $var_H;

        return new CIELCh($l, $c, $h);
    }

    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->l, $this->a, $this->b);
    }

}

