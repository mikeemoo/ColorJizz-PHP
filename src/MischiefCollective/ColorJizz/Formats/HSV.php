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
 * HSV represents the HSV color format
 *
 *
 * @author Mikee Franklin <mikeefranklin@gmail.com>
 */
class HSV extends ColorJizz
{

    /**
     * The hue
     * @var float
     */
    public $h;

    /**
     * The saturation
     * @var float
     */
    public $s;

    /**
     * The value
     * @var float
     */
    public $v;

    /**
     * Create a new HSV color
     *
     * @param float $h The hue (0-1)
     * @param float $s The saturation (0-1)
     * @param float $v The value (0-1)
     */
    public function __construct($h, $s, $v)
    {
        $this->toSelf = "toHSV";
        $this->h = $h;
        $this->s = $s;
        $this->v = $v;
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
            } else {
                if ($var_i == 4) {
                    $var_r = $var_3;
                    $var_g = $var_1;
                    $var_b = $v;
                } else {
                    $var_r = $v;
                    $var_g = $var_1;
                    $var_b = $var_2;
                }
            }

            $r = $var_r * 255;
            $g = $var_g * 255;
            $b = $var_b * 255;
        }
        return new RGB($r, $g, $b);
    }

    /**
     * Convert the color to XYZ format
     *
     * @return MischiefCollective\ColorJizz\Formats\XYZ the color in XYZ format
     */
    public function toXYZ()
    {
        return $this->toRGB()->toXYZ();
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
        return $this;
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
        return $this->toRGB()->toCIELab();
    }

    /**
     * Convert the color to CIELCh format
     *
     * @return MischiefCollective\ColorJizz\Formats\CIELCh the color in CIELCh format
     */
    public function toCIELCh()
    {
        return $this->toCIELab()->toCIELCh();
    }

    /**
     * A string representation of this color in the current format
     *
     * @return string The color in format: $h,$s,$v
     */
    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->h, $this->s, $this->v);
    }
}
