<?php

namespace MischiefCollective\ColorJizz;

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

        if (is_file($file = dirname(__FILE__) . '/../../' . str_replace(array('\\', "\0"), array('/', ''), $class) . '.php')) {
            require $file;
        }
    }

}