<?php

/*
 * This file is part of the ColorJizz package.
 *
 * (c) Mikee Franklin <mikeefranklin@gmail.com>
 *
 */

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

/**
 * XYZ represents the XYZ color format
 *
 *
 * @author Mikee Franklin <mikeefranklin@gmail.com>
 */
class XYZ extends ColorJizz
{

    /**
     * The x
     * @var float
     */
    public $x;

    /**
     * The y
     * @var float
     */
    public $y;

    /**
     * The z
     * @var float
     */
    public $z;

    /**
     * Create a new XYZ color
     *
     * @param float $x The x dimension
     * @param float $y The y dimension
     * @param float $z The z dimension
     */
    public function __construct($x, $y, $z)
    {
        $this->toSelf = "toXYZ";
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * Convert the color to Hex format
     *
     * @return \MischiefCollective\ColorJizz\Formats\Hex the color in Hex format
     */
    public function toHex()
    {
        return $this->toRGB()->toHex();
    }

    /**
     * Convert the color to RGB format
     *
     * @return \MischiefCollective\ColorJizz\Formats\RGB the color in RGB format
     */
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

    /**
     * Convert the color to XYZ format
     *
     * @return \MischiefCollective\ColorJizz\Formats\XYZ the color in XYZ format
     */
    public function toXYZ()
    {
        return $this;
    }

    /**
     * Convert the color to Yxy format
     *
     * @return \MischiefCollective\ColorJizz\Formats\Yxy the color in Yxy format
     */
    public function toYxy()
    {
        $Y = $this->y;
        $x = $this->x / ($this->x + $this->y + $this->z);
        $y = $this->y / ($this->x + $Y + $this->z);
        return new Yxy($Y, $x, $y);
    }

    /**
     * Convert the color to HSV format
     *
     * @return \MischiefCollective\ColorJizz\Formats\HSV the color in HSV format
     */
    public function toHSV()
    {
        return $this->toRGB()->toHSV();
    }

    /**
     * Convert the color to CMY format
     *
     * @return \MischiefCollective\ColorJizz\Formats\CMY the color in CMY format
     */
    public function toCMY()
    {
        return $this->toRGB()->toCMY();
    }

    /**
     * Convert the color to CMYK format
     *
     * @return \MischiefCollective\ColorJizz\Formats\CMYK the color in CMYK format
     */
    public function toCMYK()
    {
        return $this->toCMY()->toCMYK();
    }

    /**
     * Convert the color to CIELab format
     *
     * @return \MischiefCollective\ColorJizz\Formats\CIELab the color in CIELab format
     */
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

    /**
     * Convert the color to CIELCh format
     *
     * @return \MischiefCollective\ColorJizz\Formats\CIELCh the color in CIELCh format
     */
    public function toCIELCh()
    {
        return $this->toCIELab()->toCIELCh();
    }

    /**
     * A string representation of this color in the current format
     *
     * @return string The color in format: $x,$y,$z
     */
    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->x, $this->y, $this->z);
    }
}
