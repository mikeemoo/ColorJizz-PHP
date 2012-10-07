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
 * CIELCh represents the CIELCh color format
 *
 *
 * @author Mikee Franklin <mikee@mischiefcollective.com>
 */
class CIELCh extends ColorJizz
{

    /**
     * The lightness
     * @var float
     */
    public $l;

    /**
     * The chroma
     * @var float
     */
    public $c;

    /**
     * The hue
     * @var float
     */
    public $h;

    /**
     * Create a new CIELCh color
     *
     * @param float $l The lightness
     * @param float $c The chroma
     * @param float $h The hue
     */
    public function __construct($l, $c, $h)
    {
        $this->toSelf = "toCIELCh";
        $this->l = $l;
        $this->c = $c;
        $this->h = fmod($h, 360);
        if ($this->h < 0) {
            $this->h += 360;
        }
    }

    /**
     * Convert the color to Hex format
     *
     * @return MischiefCollective\ColorJizz\Formats\Hex the color in Hex format
     */
    public function toHex()
    {
        return $this->toCIELab()->toHex();
    }

    /**
     * Convert the color to RGB format
     *
     * @return MischiefCollective\ColorJizz\Formats\RGB the color in RGB format
     */
    public function toRGB()
    {
        return $this->toCIELab()->toRGB();
    }

    /**
     * Convert the color to XYZ format
     *
     * @return MischiefCollective\ColorJizz\Formats\XYZ the color in XYZ format
     */
    public function toXYZ()
    {
        return $this->toCIELab()->toXYZ();
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
        return $this->toCIELab()->toHSV();
    }

    /**
     * Convert the color to CMY format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMY the color in CMY format
     */
    public function toCMY()
    {
        return $this->toCIELab()->toCMY();
    }

    /**
     * Convert the color to CMYK format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMYK the color in CMYK format
     */
    public function toCMYK()
    {
        return $this->toCIELab()->toCMYK();
    }

    /**
     * Convert the color to CIELab format
     *
     * @return MischiefCollective\ColorJizz\Formats\CIELab the color in CIELab format
     */
    public function toCIELab()
    {
        $l = $this->l;
        $hradi = $this->h * (pi() / 180);
        $a = cos($hradi) * $this->c;
        $b = sin($hradi) * $this->c;
        return new CIELab($l, $a, $b);
    }

    /**
     * Convert the color to CIELCh format
     *
     * @return MischiefCollective\ColorJizz\Formats\CIELCh the color in CIELCh format
     */
    public function toCIELCh()
    {
        return $this;
    }

    /**
     * A string representation of this color in the current format
     *
     * @return string The color in format: $l,$c,$h
     */
    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->l, $this->c, $this->h);
    }

}
