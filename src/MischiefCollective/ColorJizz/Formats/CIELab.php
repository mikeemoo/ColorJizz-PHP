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
 * CIELab represents the CIELab color format
 *
 *
 * @author Mikee Franklin <mikeefranklin@gmail.com>
 */
class CIELab extends ColorJizz
{

    /**
     * The lightness
     * @var float
     */
    public $lightness;

    /**
     * The a dimension
     * @var float
     */
    public $a_dimension;

    /**
     * The b dimenson
     * @var float
     */
    public $b_dimension;

    /**
     * Create a new CIELab color
     *
     * @param float $l The lightness
     * @param float $a The a dimenson
     * @param float $b The b dimenson
     */
    public function __construct($lightness, $a_dimension, $b_dimension)
    {
        $this->toSelf = "toCIELab";
        $this->lightness = $lightness; //$this->roundDec($l, 3);
        $this->a_dimension = $a_dimension; //$this->roundDec($a, 3);
        $this->b_dimension = $b_dimension; //$this->roundDec($b, 3);
    }

    public static function create($lightness, $a_dimension, $b_dimension)
    {
        return new CIELab($lightness, $a_dimension, $b_dimension);
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

        $var_Y = ($this->lightness + 16) / 116;
        $var_X = $this->a_dimension / 500 + $var_Y;
        $var_Z = $var_Y - $this->b_dimension / 200;

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
        $position_x = $ref_X * $var_X;
        $position_y = $ref_Y * $var_Y;
        $position_z = $ref_Z * $var_Z;
        return new XYZ($position_x, $position_y, $position_z);
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
        $var_H = atan2($this->b_dimension, $this->a_dimension);

        if ($var_H > 0) {
            $var_H = ($var_H / pi()) * 180;
        } else {
            $var_H = 360 - (abs($var_H) / pi()) * 180;
        }

        $lightness = $this->lightness;
        $chroma = sqrt(pow($this->a_dimension, 2) + pow($this->b_dimension, 2));
        $hue = $var_H;

        return new CIELCh($lightness, $chroma, $hue);
    }

    /**
     * A string representation of this color in the current format
     *
     * @return string The color in format: $lightness,$a_dimension,$b_dimension
     */
    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->lightness, $this->a_dimension, $this->b_dimension);
    }
}
