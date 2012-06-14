<?php

namespace MischiefCollective\ColorJizz\Formats;

use MischiefCollective\ColorJizz\ColorJizz;

class Yxy extends ColorJizz
{

    public $Y;
    public $x;
    public $y;

    public function __construct($Y, $x, $y)
    {
        $this->toSelf = "toYxy";
        $this->Y = $Y;
        $this->x = $x;
        $this->y = $y;
    }

    public function toHex()
    {
        return $this->toXYZ()->toYxy();
    }

    public function toRGB()
    {
        return $this->toXYZ()->toRGB();
    }

    public function toXYZ()
    {
        $X = $this->x * ($this->Y / $this->y);
        $Y = $this->Y;
        $Z = (1 - $this->x - $this->y) * ($this->Y / $this->y);
        return new XYZ($X, $Y, $Z);
    }

    public function toYxy()
    {
        return $this;
    }

    public function toHSV()
    {
        return $this->toXYZ()->toHSV();
    }

    public function toCMY()
    {
        return $this->toXYZ()->toCMY();
    }

    public function toCMYK()
    {
        return $this->toXYZ()->toCMYK();
    }

    public function toCIELab()
    {
        return $this->toXYZ()->toCIELab();
    }

    public function toCIELCh()
    {
        return $this->toXYZ()->toCIELCh();
    }

    public function __toString()
    {
        return sprintf('%s,%s,%s', $this->Y, $this->x, $this->y);
    }

}
