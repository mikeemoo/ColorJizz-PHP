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
 * CMYK represents the CMYK color format
 *
 *
 * @author Mikee Franklin <mikee@mischiefcollective.com>
 */
class CMYK extends ColorJizz
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
     * The key (black)
     * @var float
     */
    public $k;
   
   /**
    * Create a new CMYK color
    * 
    * @param float $c The cyan
    * @param float $m The magenta
    * @param float $y The yellow
    * @param float $k The key (black)
    */
    public function __construct($c, $m, $y, $k)
    {
        $this->toSelf = "toCMYK";
        $this->c = $c;
        $this->m = $m;
        $this->y = $y;
        $this->k = $k;
    }

    public static function create($c, $m, $y, $k)
    {
        return new CMYK($c, $m, $y, $k);
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
        return $this->toCMY()->toRGB();
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
        $C = ($this->c * (1 - $this->k) + $this->k);
        $M = ($this->m * (1 - $this->k) + $this->k);
        $Y = ($this->y * (1 - $this->k) + $this->k);
        return new CMY($C, $M, $Y);
    }

   /**
    * Convert the color to CMYK format
    *
    * @return MischiefCollective\ColorJizz\Formats\CMYK the color in CMYK format
    */
    public function toCMYK()
    {
        return $this;
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
    * @return string The color in format: $c,$m,$y,$k
    */
    public function __toString()
    {
        return sprintf('%s,%s,%s,%s', $this->c, $this->m, $this->y, $this->k);
    }

}