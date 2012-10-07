<?php

/*
 * This file is part of the ColorJizz package.
 *
 * (c) Mikee Franklin <mikee@mischiefcollective.com>
 *
 */

namespace MischiefCollective\ColorJizz;

use MischiefCollective\ColorJizz\Formats\HSV,
    MischiefCollective\ColorJizz\Formats\CIELCh,
    MischiefCollective\ColorJizz\Formats\RGB,
    MischiefCollective\ColorJizz\Formats\Hex;

/**
 * ColorJizz is the base class that all color objects extend
 *
 *
 * @author Mikee Franklin <mikee@mischiefcollective.com>
 */
abstract class ColorJizz
{

    protected $toSelf;

    /**
     * Convert the color to Hex format
     *
     * @return MischiefCollective\ColorJizz\Formats\Hex the color in Hex format
     */
    abstract public function toHex();

    /**
     * Convert the color to RGB format
     *
     * @return MischiefCollective\ColorJizz\Formats\RGB the color in RGB format
     */
    abstract public function toRGB();

    /**
     * Convert the color to XYZ format
     *
     * @return MischiefCollective\ColorJizz\Formats\XYZ the color in XYZ format
     */
    abstract public function toXYZ();

    /**
     * Convert the color to Yxy format
     *
     * @return MischiefCollective\ColorJizz\Formats\Yxy the color in Yxy format
     */
    abstract public function toYxy();

    /**
     * Convert the color to CIELab format
     *
     * @return MischiefCollective\ColorJizz\Formats\CIELab the color in CIELab format
     */
    abstract public function toCIELab();

    /**
     * Convert the color to CIELCh format
     *
     * @return MischiefCollective\ColorJizz\Formats\CIELCh the color in CIELCh format
     */
    abstract public function toCIELCh();

    /**
     * Convert the color to CMY format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMY the color in CMY format
     */
    abstract public function toCMY();

    /**
     * Convert the color to CMYK format
     *
     * @return MischiefCollective\ColorJizz\Formats\CMYK the color in CMYK format
     */
    abstract public function toCMYK();

    /**
     * Convert the color to HSV format
     *
     * @return MischiefCollective\ColorJizz\Formats\HSV the color in HSV format
     */
    abstract public function toHSV();

    /**
     * Find the distance to the destination color
     *
     * @param MischiefCollective\ColorJizz\ColorJizz $destinationColor The destination color
     *
     * @return int distance to destination color
     */
    public function distance(ColorJizz $destinationColor)
    {
        $a = $this->toCIELab();
        $b = $destinationColor->toCIELab();

        return sqrt(pow(($a->l - $b->l), 2) + pow(($a->a - $b->a), 2) + pow(($a->b - $b->b), 2));
    }

    /**
     * Find the closest websafe color
     *
     * @return MischiefCollective\ColorJizz\ColorJizz The closest color
     */
    public function websafe()
    {
        $c = array('00', 'CC', '33', '66', '99', 'FF');
        $palette = array();
        for ($i = 0; $i < 6; $i++) {
            for ($j = 0; $j < 6; $j++) {
                for ($k = 0; $k < 6; $k++) {
                    $palette[] = new Hex($c[$i] + $c[$j] + $c[$k]);
                }
            }
        }
        return $this->match($palette);
    }

    /**
     * Match the current color to the closest from the array $palette
     *
     * @param array $palette An array of ColorJizz objects to match against
     *
     * @return MischiefCollective\ColorJizz\ColorJizz The closest color
     */
    public function match(array $palette)
    {
        $distance = 100000000000;
        $closest = null;
        for ($i = 0; $i < count($palette); $i++) {
            $cdistance = $this->distance($palette[$i]);
            if ($distance == 100000000000 || $cdistance < $distance) {
                $distance = $cdistance;
                $closest = $palette[$i];
            }
        }
        return call_user_func(array($closest, $this->toSelf));
    }

    public function equal($parts, $includeSelf = false)
    {
        $parts = max($parts, 2);
        $current = $this->toCIELCh();
        $distance = 360 / $parts;
        $palette = array();
        if ($includeSelf) {
            $palette[] = $this;
        }
        for ($i = 1; $i < $parts; $i++) {
            $t = new CIELCh($current->l, $current->c, $current->h + ($distance * $i));
            $palette[] = call_user_func(array($t, $this->toSelf));
        }
        return $palette;
    }

    public function split($includeSelf = false)
    {
        $rtn = array();
        $t = $this->hue(-150);
        $rtn[] = call_user_func(array($t, $this->toSelf));
        if ($includeSelf) {
            $rtn[] = $this;
        }
        $t = $this->hue(150);
        $rtn[] = call_user_func(array($t, $this->toSelf));
        return $rtn;
    }

    /**
     * Return the opposite, complimentary color
     *
     * @return MischiefCollective\ColorJizz\ColorJizz The greyscale color
     */
    public function complement()
    {
        return $this->hue(180);
    }

    /**
     * Find complimentary colors
     *
     * @param int $includeSelf Include the current color in the return array
     *
     * @return MischiefCollective\ColorJizz\ColorJizz[] Array of complimentary colors
     */
    public function sweetspot($includeSelf = false)
    {
        $colors = array($this->toHSV());
        $colors[1] = new HSV($colors[0]->h, round($colors[0]->s * 0.3), min(round($colors[0]->v * 1.3), 100));
        $colors[3] = new HSV(($colors[0]->h + 300) % 360, $colors[0]->s, $colors[0]->v);
        $colors[2] = new HSV($colors[1]->h, min(round($colors[1]->s * 1.2), 100), min(round($colors[1]->v * 0.5), 100));
        $colors[4] = new HSV($colors[2]->h, 0, ($colors[2]->v + 50) % 100);
        $colors[5] = new HSV($colors[4]->h, $colors[4]->s, ($colors[4]->v + 50) % 100);
        if (!$includeSelf) {
            array_shift($colors);
        }
        for ($i = 0; $i < count($colors); $i++) {
            $colors[$i] = call_user_func(array($colors[$i], $this->toSelf));
        }
        return $colors;
    }

    public function analogous($includeSelf = false)
    {
        $rtn = array();
        $t = $this->hue(-30);
        $rtn[] = call_user_func(array($t, $this->toSelf));

        if ($includeSelf) {
            $rtn[] = $this;
        }

        $t = $this->hue(30);
        $rtn[] = call_user_func(array($t, $this->toSelf));
        return $rtn;
    }

    public function rectangle($sideLength, $includeSelf = false)
    {
        $side1 = $sideLength;
        $side2 = (360 - ($sideLength * 2)) / 2;
        $current = $this->toCIELCh();
        $rtn = array();

        $t = new CIELCh($current->l, $current->c, $current->h + $side1);
        $rtn[] = call_user_func(array($t, $this->toSelf));

        $t = new CIELCh($current->l, $current->c, $current->h + $side1 + $side2);
        $rtn[] = call_user_func(array($t, $this->toSelf));

        $t = new CIELCh($current->l, $current->c, $current->h + $side1 + $side2 + $side1);
        $rtn[] = call_user_func(array($t, $this->toSelf));

        if ($includeSelf) {
            array_unshift($rtn, $this);
        }

        return $rtn;
    }

    public function range($destinationColor, $steps, $includeSelf = false)
    {
        $a = $this->toRGB();
        $b = $destinationColor->toRGB();
        $colors = array();
        $steps--;
        for ($n = 1; $n < $steps; $n++) {
            $nr = floor($a->r + ($n * ($b->r - $a->r) / $steps));
            $ng = floor($a->g + ($n * ($b->g - $a->g) / $steps));
            $nb = floor($a->b + ($n * ($b->b - $a->b) / $steps));
            $t = new RGB($nr, $ng, $nb);
            $colors[] = call_user_func(array($t, $this->toSelf));
        }
        if ($includeSelf) {
            array_unshift($colors, $this);
            $colors[] = call_user_func(array($destinationColor, $this->toSelf));
        }
        return $colors;
    }

    /**
     * Return a greyscale version of the current color
     *
     * @return MischiefCollective\ColorJizz\ColorJizz The greyscale color
     */
    public function greyscale()
    {
        $a = $this->toRGB();
        $ds = $a->r * 0.3 + $a->g * 0.59 + $a->b * 0.11;
        $t = new RGB($ds, $ds, $ds);
        return call_user_func(array($t, $this->toSelf));
    }

    /**
     * Modify the hue by $degreeModifier degrees
     *
     * @param int $degreeModifier Degrees to modify by
     *
     * @return MischiefCollective\ColorJizz\ColorJizz The modified color
     */
    public function hue($degreeModifier)
    {
        $a = $this->toCIELCh();
        $a->h += $degreeModifier;
        $a->h = fmod($a->h, 360);
        return call_user_func(array($a, $this->toSelf));
    }

    /**
     * Modify the saturation by $brightnessModifier
     *
     * @param int $satModifier Value to modify by
     *
     * @return MischiefCollective\ColorJizz\ColorJizz The modified color
     */
    public function saturation($satModifier)
    {
        $a = $this->toHSV();
        $a->s += ($satModifier / 100);
        $a->s = min(1, max(0, $a->s));
        return call_user_func(array($a, $this->toSelf));
    }

    /**
     * Modify the brightness by $brightnessModifier
     *
     * @param int $brightnessModifier Value to modify by
     *
     * @return MischiefCollective\ColorJizz\ColorJizz The modified color
     */
    public function brightness($brightnessModifier)
    {
        $a = $this->toCIELab();
        $a->l += $brightnessModifier;
        return call_user_func(array($a, $this->toSelf));
    }

}
