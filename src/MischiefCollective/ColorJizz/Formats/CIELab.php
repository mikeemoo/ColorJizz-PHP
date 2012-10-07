<?php

/*
 * This file is part of the ColorJizz package.
 *
 * (c) Mikee Franklin <mikee@mischiefcollective.com>
 *
 */

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

/**
 * CIELab represents the CIELab color format
 *
 *
 * @author Mikee Franklin <mikee@mischiefcollective.com>
 */
class CIELab extends ColorJizz
{

    /**
     * The lightness
     * @var float
     */
    public $l;

    /**
     * The a dimenson
     * @var float
     */
    public $a;

    /**
     * The b dimenson
     * @var float
     */
    public $b;

    /**
     * Create a new CIELab color
     *
     * @param float $l The lightness
     * @param float $a The a dimenson
     * @param float $b The b dimenson
     */
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

    /**
     * Convert the color to Hex format
     *
     * @return MischiefCollective\ColorJizz\Formats\Hex the color in Hex format
     */
    public function toHex()
    {
        return $this->toRGB()->toHex();
    }

    /**
     * Convert the color to RGB format
     *
     * @return MischiefCollective\ColorJizz\Formats\RGB the color in RGB format
     */
    public function toRGB()
    {
        return $this->toXYZ()->toRGB();
    }

    /**
     * Convert the color to XYZ format
     *
     * @return MischiefCollective\ColorJizz\Formats\XYZ the color in XYZ format
     */
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

    /**
     * Convert the color to Yxy format
     *
     * @return MischiefCollective\ColorJizz\Formats\Yxy the color in Yxy format
     */
    public function toYxy()
    {
        return $this->toXYZ()->toYxy();
    }

    /**
     * Convert the color to HSV format
     *
     * @return MischiefCollective\ColorJizz\Formats\HSV the color in HSV format
     */
    public function toHSV()
    {
        return $this->toRGB()->toHSV();
    }

    /**
     * Convert the color to CMY format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMY the color in CMY format
     */
    public function toCMY()
    {
        return $this->toRGB()->toCMY();
    }

    /**
     * Convert the color to CMYK format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMYK the color in CMYK format
     */
    public function toCMYK()
    {
        return $this->toCMY()->toCMYK();
    }

    /**
     * Convert the color to CIELab format
     *
     * @return MischiefCollective\ColorJizz\Formats\CIELab the color in CIELab format
     */
    public function toCIELab()
    {
        return $this;
    }

    /**
     * Convert the color to CIELCh format
     *
     * @return MischiefCollective\ColorJizz\Formats\CIELCh the color in CIELCh format
     */
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

    /**
     * A string representation of this color in the current format
     *
     * @return string The color in format: $l,$a,$b
     */
    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->l, $this->a, $this->b);
    }
}
