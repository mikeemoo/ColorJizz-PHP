<?php

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

class XYZ extends ColorJizz
{

    public $x;
    public $y;
    public $z;

    public function __construct($x, $y, $z)
    {
        $this->toSelf = "toXYZ";
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    public function toHex()
    {
        return $this->toRGB()->toHex();
    }

    public function toRGB()
    {
        $var_X = $this->x / 100;
        $var_Y = $this->y / 100;
        $var_Z = $this->z / 100;

        $var_R = $var_X * 3.2406 + $var_Y * -1.5372 + $var_Z * -0.4986;
        $var_G = $var_X * -0.9689 + $var_Y * 1.8758 + $var_Z * 0.0415;
        $var_B = $var_X * 0.0557 + $var_Y * -0.2040 + $var_Z * 1.0570;

        if ($var_R > 0.0031308) {
            $var_R = 1.055 * pow($var_R, (1 / 2.4)) - 0.055;
        } else {
            $var_R = 12.92 * $var_R;
        }
        if ($var_G > 0.0031308) {
            $var_G = 1.055 * pow($var_G, (1 / 2.4)) - 0.055;
        } else {
            $var_G = 12.92 * $var_G;
        }
        if ($var_B > 0.0031308) {
            $var_B = 1.055 * pow($var_B, (1 / 2.4)) - 0.055;
        } else {
            $var_B = 12.92 * $var_B;
        }
        $var_R = max(0, min(255, $var_R * 255));
        $var_G = max(0, min(255, $var_G * 255));
        $var_B = max(0, min(255, $var_B * 255));
        return new RGB($var_R, $var_G, $var_B);
    }

    public function toXYZ()
    {
        return $this;
    }

    public function toYxy()
    {
        $Y = $this->y;
        $x = $this->x / ($this->x + $this->y + $this->z);
        $y = $this->y / ($this->x + $Y + $this->z);
        return new Yxy($Y, $x, $y);
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
        $Xn = 95.047;
        $Yn = 100.000;
        $Zn = 108.883;

        $x = $this->x / $Xn;
        $y = $this->y / $Yn;
        $z = $this->z / $Zn;

        if ($x > 0.008856) {
            $x = pow($x, 1 / 3);
        } else {
            $x = (7.787 * $x) + (16 / 116);
        }
        if ($y > 0.008856) {
            $y = pow($y, 1 / 3);
        } else {
            $y = (7.787 * $y) + (16 / 116);
        }
        if ($z > 0.008856) {
            $z = pow($z, 1 / 3);
        } else {
            $z = (7.787 * $z) + (16 / 116);
        }
        if ($y > 0.008856) {
            $l = (116 * $y) - 16;
        } else {
            $l = 903.3 * $y;
        }
        $a = 500 * ($x - $y);
        $b = 200 * ($y - $z);

        return new CIELab($l, $a, $b);
    }

    public function toCIELCh()
    {
        return $this->toCIELab()->toCIELCh();
    }

    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->x, $this->y, $this->z);
    }

}
