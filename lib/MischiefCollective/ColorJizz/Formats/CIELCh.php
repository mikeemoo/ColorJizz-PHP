<?php

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

class CIELCh extends ColorJizz
{

    public $l;
    public $c;
    public $h;

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

    public function toHex()
    {
        return $this->toCIELab()->toHex();
    }

    public function toRGB()
    {
        return $this->toCIELab()->toRGB();
    }

    public function toXYZ()
    {
        return $this->toCIELab()->toXYZ();
    }

    public function toYxy()
    {
        return $this->toXYZ()->toYxy();
    }

    public function toHSV()
    {
        return $this->toCIELab()->toHSV();
    }

    public function toCMY()
    {
        return $this->toCIELab()->toCMY();
    }

    public function toCMYK()
    {
        return $this->toCIELab()->toCMYK();
    }

    public function toCIELab()
    {
        $l = $this->l;
        $hradi = $this->h * (pi() / 180);
        $a = cos($hradi) * $this->c;
        $b = sin($hradi) * $this->c;
        return new CIELab($l, $a, $b);
    }

    public function toCIELCh()
    {
        return $this;
    }

    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->l, $this->c, $this->h);
    }

}
