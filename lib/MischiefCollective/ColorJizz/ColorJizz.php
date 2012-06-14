<?php

namespace MischiefCollective\ColorJizz;

use MischiefCollective\ColorJizz\Formats\HSV,
    MischiefCollective\ColorJizz\Formats\CIELCh,
    MischiefCollective\ColorJizz\Formats\RGB,
    MischiefCollective\ColorJizz\Formats\Hex;

abstract class ColorJizz
{

    protected $toSelf;

    abstract public function toHex();

    abstract public function toRGB();

    abstract public function toXYZ();

    abstract public function toYxy();

    abstract public function toCIELab();

    abstract public function toCIELCh();

    abstract public function toCMY();

    abstract public function toCMYK();

    abstract public function toHSV();

    public function distance(ColorJizz $destinationColor)
    {
        $a = $this->toCIELab();
        $b = $destinationColor->toCIELab();

        return sqrt(pow(($a->l - $b->l), 2) + pow(($a->a - $b->a), 2) + pow(($a->b - $b->b), 2));
    }

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

    public function match($palette)
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

    public function complement($includeSelf = false)
    {
        $rtn = array();
        $t = $this->hue(180);
        $rtn[] = call_user_func(array($t, $this->toSelf));
        if ($includeSelf) {
            array_unshift($rtn, $this);
        }
        return $rtn;
    }

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

    public function greyscale()
    {
        $a = $this->toRGB();
        $ds = $a->r * 0.3 + $a->g * 0.59 + $a->b * 0.11;
        $t = new RGB($ds, $ds, $ds);
        return call_user_func(array($t, $this->toSelf));
    }

    public function hue($degreeModifier)
    {
        $a = $this->toCIELCh();
        $a->h += $degreeModifier;
        return call_user_func(array($a, $this->toSelf));
    }

    public function saturation($satModifier)
    {
        $a = $this->toHSV();
        $a->s += ($satModifier / 100);
        $a->s = min(1, max(0, $a->s));
        return call_user_func(array($a, $this->toSelf));
    }

    public function brightness($brightnessModifier)
    {
        $a = $this->toCIELab();
        $a->l += $brightnessModifier;
        return call_user_func(array($a, $this->toSelf));
    }

}
