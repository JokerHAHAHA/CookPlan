<?php

session_start();

use CookPlan\Autoloader;
use CookPlan\Model\Database;
use CookPlan\Model\User;

//load Twig
include_once('../twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../templates'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
  'cache' => false
  ));

require '../src/Autoloader.php';
Autoloader::require();

$login = new User();

if($login->is_loggedin()!="")
{
    $login->redirect('./meals.php');
}

if(isset($_POST['btn-signin']))
{
    $uname = strip_tags($_POST['login']);
    $umail = strip_tags($_POST['login']);
    $upass = strip_tags($_POST['password']);

    if($login->doLogin($uname,$umail,$upass))
    {
        header("Location: meals.php");
    }
    else
    {
        echo $twig->render('login.html.twig', array('error' => "Les informations sont incorrectes"));
    }   
}
else
{
    echo $twig->render('login.html.twig');
}

