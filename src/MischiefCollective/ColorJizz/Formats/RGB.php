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
 * RGB represents the RGB color format
 *
 *
 * @author Mikee Franklin <mikeefranklin@gmail.com>
 */
class RGB extends ColorJizz
{

    /**
     * The red value (0-255)
     * @var float
     */
    public $r;

    /**
     * The green value (0-255)
     * @var float
     */
    public $g;

    /**
     * The blue value (0-255)
     * @var float
     */
    public $b;

    /**
     * Create a new RGB color
     *
     * @param float $r The red (0-255)
     * @param float $g The green (0-255)
     * @param float $b The blue (0-255)
     */
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

    /**
     * Get the red value (rounded)
     *
     * @return int The red value
     */
    public function getR()
    {
        return (0.5 + $this->r) | 0;
    }

    /**
     * Get the green value (rounded)
     *
     * @return int The green value
     */
    public function getG()
    {
        return (0.5 + $this->g) | 0;
    }

    /**
     * Get the blue value (rounded)
     *
     * @return int The blue value
     */
    public function getB()
    {
        return (0.5 + $this->b) | 0;
    }

    /**
     * Convert the color to Hex format
     *
     * @return MischiefCollective\ColorJizz\Formats\Hex the color in Hex format
     */
    public function toHex()
    {
        return new Hex($this->getR() << 16 | $this->getG() << 8 | $this->getB());
    }

    /**
     * Convert the color to RGB format
     *
     * @return MischiefCollective\ColorJizz\Formats\RGB the color in RGB format
     */
    public function toRGB()
    {
        return $this;
    }

    /**
     * Convert the color to XYZ format
     *
     * @return MischiefCollective\ColorJizz\Formats\XYZ the color in XYZ format
     */
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
        } else {
            if ($g == $max) {
                $h = 2 + ($b - $r) / $delta;
            } else {
                $h = 4 + ($r - $g) / $delta;
            }
        }
        $h *= 60;
        if ($h < 0) {
            $h += 360;
        }

        return new HSV($h, $s * 100, $v * 100);
    }

    /**
     * Convert the color to CMY format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMY the color in CMY format
     */
    public function toCMY()
    {
        $C = 1 - ($this->r / 255);
        $M = 1 - ($this->g / 255);
        $Y = 1 - ($this->b / 255);
        return new CMY($C, $M, $Y);
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
        return $this->toXYZ()->toCIELab();
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
     * @return string The color in format: $r,$g,$b (rounded)
     */
    public function toString()
    {
        return $this->getR() . ',' . $this->getG() . ',' . $this->getB();
    }
}
