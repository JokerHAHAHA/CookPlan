<?php

namespace CookPlan;

/**
 * to require dynamicaly
*/
class Autoloader
{
    static function load(){

        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class){

        $class = str_replace(__NAMESPACE__.'\\', '', $class);
        $class = str_replace('\\', '/', $class);

        require '../src/' . $class . '.php';
    }
}