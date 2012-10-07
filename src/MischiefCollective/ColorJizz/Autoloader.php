<?php

/*
 * This file is part of the ColorJizz package.
 *
 * (c) Mikee Franklin <mikee@mischiefcollective.com>
 *
 */

namespace MischiefCollective\ColorJizz;

/**
 * Autoloader is used to autoload the library files
 *
 *
 * @author Mikee Franklin <mikee@mischiefcollective.com>
 */
class Autoloader
{

    static public function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    static public function autoload($class)
    {
        if (0 !== strpos($class, 'MischiefCollective\\ColorJizz')) {
            return;
        }

        if (is_file(
            $file = dirname(__FILE__) . '/../../' . str_replace(array('\\', "\0"), array('/', ''), $class) . '.php'
        )
        ) {
            require $file;
        }
    }

}