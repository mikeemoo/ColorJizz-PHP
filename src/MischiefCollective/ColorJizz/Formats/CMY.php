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
 * CMY represents the CMY color format
 *
 *
 * @author Mikee Franklin <mikee@mischiefcollective.com>
 */
class CMY extends ColorJizz
{

    /**
     * The cyan
     * @var float
     */
    public $c;

    /**
     * The magenta
     * @var float
     */
    public $m;

    /**
     * The yellow
     * @var float
     */
    public $y;

    /**
     * Create a new CIELab color
     *
     * @param float $c The cyan
     * @param float $m The magenta
     * @param float $y The yellow
     */
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
        $r = (1 - $this->c) * 255;
        $g = (1 - $this->m) * 255;
        $b = (1 - $this->y) * 255;
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
        return $this->toRGB()->toHSV();
    }

    /**
     * Convert the color to CMY format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMY the color in CMY format
     */
    public function toCMY()
    {
        return $this;
    }

    /**
     * Convert the color to CMYK format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMYK the color in CMYK format
     */
    public function toCMYK()
    {
        $var_K = 1;
        $C = $this->c;
        $M = $this->m;
        $Y = $this->y;
        if ($C < $var_K)
                {
                    $var_K = $C;
                }
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
     * @return string The color in format: $c,$m,$y
     */
    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->c, $this->m, $this->y);
    }

}
