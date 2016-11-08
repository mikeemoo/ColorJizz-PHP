<?php

/*
 * This file is part of the ColorJizz package.
 *
 * (c) Mikee Franklin <mikeefranklin@gmail.com>
 *
 */

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;
use MischiefCollective\ColorJizz\Exceptions\InvalidArgumentException;

/**
 * HSL represents the HSL color format
 *
 *
 * @author Drake Parker <e.drake.p@gmail.com>
 */
class HSL extends ColorJizz
{

    /**
     * The hue
     * @var float
     */
    public $hue;

    /**
     * The saturation
     * @var float
     */
    public $saturation;

    /**
     * The lightness
     * @var float
     */
    public $lightness;

    /**
     * Create a new HSL color
     *
     * @param float $hue The hue (0-1)
     * @param float $saturation The saturation (0-1)
     * @param float $lightness The lightness (0-1)
     */
    public function __construct($hue, $saturation, $lightness)
    {
        $this->toSelf = "toHSL";
        $this->hue = $hue;
        $this->saturation = $saturation;
        $this->lightness = $lightness;
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
        return $this->toHSV()->toRGB();
    }

    /**
     * Convert the color to XYZ format
     *
     * @return \MischiefCollective\ColorJizz\Formats\XYZ the color in XYZ format
     */
    public function toXYZ()
    {
        return $this->toRGB()->toXYZ();
    }

    /**
     * Convert the color to Yxy format
     *
     * @return \MischiefCollective\ColorJizz\Formats\Yxy the color in Yxy format
     */
    public function toYxy()
    {
        return $this->toXYZ()->toYxy();
    }

    /**
     * Convert the color to HSL format
     *
     * @return \MischiefCollective\ColorJizz\Formats\HSL the color in HSL format
     */
    public function toHSL()
    {
        return $this;
    }

    /**
     * Convert the color to HSV format
     *
     * @return \MischiefCollective\ColorJizz\Formats\HSV the color in HSV format
     */
    public function toHSV()
    {
        $temp = $this->saturation * ($this->lightness < 50 ? $this->lightness : 100 - $this->lightness) / 100;

        $h = $this->hue;
        $v = $temp + $this->lightness;
        $s = ($this->lightness + $temp > 0)
            ? 200 * $temp / ($this->lightness + $temp)
            : 0;

        return new HSV($h, $s, $v);
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
        return $this->toRGB()->toCIELab();
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
     * @return string The color in format: $hue,$saturation,$lightness
     */
    public function __toString()
    {
        return sprintf('%01.4f, %01.4f, %01.4f', $this->hue, $this->saturation, $this->lightness);
    }
}
