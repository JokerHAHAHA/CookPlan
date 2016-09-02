<?php

session_start();

use CookPlan\Autoloader;
use CookPlan\Model\Database;
use CookPlan\Model\User;

//load twig
include_once('../twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates'); 
$twig = new Twig_Environment($loader, array(
  'cache' => false
  ));

//load classes
require '../src/Autoloader.php';
Autoloader::require();
