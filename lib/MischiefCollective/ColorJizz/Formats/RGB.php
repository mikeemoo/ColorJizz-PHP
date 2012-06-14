<?php

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz,
    MischiefCollective\ColorJizz\Exceptions\InvalidArgumentException;

class RGB extends ColorJizz
{

    public $r;
    public $g;
    public $b;

    public function __construct($r, $g, $b)
    {
        $this->toSelf = "toRGB";

        if ($r < 0 || $r > 255) {
          throw new InvalidArgumentException(sprintf('Parameter r out of range (%s)', $r));
        }
        if ($g < 0 || $g > 255) {
          throw new InvalidArgumentException(sprintf('Parameter g out of range (%s)', $g));
        }
        if ($b < 0 || $b > 255) {
          throw new InvalidArgumentException(sprintf('Parameter b out of range (%s)', $b));
        }

        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
    }

    public function getR()
    {
        return (0.5 + $this->r) | 0;
    }

    public function getG()
    {
        return (0.5 + $this->g) | 0;
    }

    public function getB()
    {
        return (0.5 + $this->b) | 0;
    }

    public function toHex()
    {
        return new Hex($this->getR() << 16 | $this->getG() << 8 | $this->getB());
    }

    public function toRGB()
    {
        return $this;
    }

    public function toXYZ()
    {
        $tmp_r = $this->r / 255;
        $tmp_g = $this->g / 255;
        $tmp_b = $this->b / 255;
        if ($tmp_r > 0.04045) {
            $tmp_r = pow((($tmp_r + 0.055) / 1.055), 2.4);
        } else {
            $tmp_r = $tmp_r / 12.92;
        }
        if ($tmp_g > 0.04045) {
            $tmp_g = pow((($tmp_g + 0.055) / 1.055), 2.4);
        } else {
            $tmp_g = $tmp_g / 12.92;
        }
        if ($tmp_b > 0.04045) {
            $tmp_b = pow((($tmp_b + 0.055) / 1.055), 2.4);
        } else {
            $tmp_b = $tmp_b / 12.92;
        }
        $tmp_r = $tmp_r * 100;
        $tmp_g = $tmp_g * 100;
        $tmp_b = $tmp_b * 100;
        $x = $tmp_r * 0.4124 + $tmp_g * 0.3576 + $tmp_b * 0.1805;
        $y = $tmp_r * 0.2126 + $tmp_g * 0.7152 + $tmp_b * 0.0722;
        $z = $tmp_r * 0.0193 + $tmp_g * 0.1192 + $tmp_b * 0.9505;
        return new XYZ($x, $y, $z);
    }

    public function toYxy()
    {
        return $this->toXYZ()->toYxy();
    }

    public function toHSV()
    {
        $r = $this->r / 255;
        $g = $this->g / 255;
        $b = $this->b / 255;


        $min = min($r, $g, $b);
        $max = max($r, $g, $b);

        $v = $max;
        $delta = $max - $min;

        if ($delta == 0) {
            return new HSV(0, 0, $v * 100);
        }
        if ($max != 0) {
            $s = $delta / $max;
        } else {
            $s = 0;
            $h = -1;
            return new HSV($h, $s, $v);
        }
        if ($r == $max) {
            $h = ($g - $b) / $delta;
        } else if ($g == $max) {
            $h = 2 + ($b - $r) / $delta;
        } else {
            $h = 4 + ($r - $g) / $delta;
        }
        $h *= 60;
        if ($h < 0) {
            $h += 360;
        }

        return new HSV($h, $s * 100, $v * 100);
    }

    public function toCMY()
    {
        $C = 1 - ($this->r / 255);
        $M = 1 - ($this->g / 255);
        $Y = 1 - ($this->b / 255);
        return new CMY($C, $M, $Y);
    }

    public function toCMYK()
    {
        return $this->toCMY()->toCMYK();
    }

    public function toCIELab()
    {
        return $this->toXYZ()->toCIELab();
    }

    public function toCIELCh()
    {
        return $this->toCIELab()->toCIELCh();
    }

    public function toString()
    {
        return $this->getR() . ',' . $this->getG() . ',' . $this->getB();
    }

}

