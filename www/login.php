<?php

session_start();
use Cookplan\Autoloader;
use Cookplan\Model\User;
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
//var_dump('coucou');
// if($login->is_loggedin()!="")
// {
//     echo $twig->render('meals.html.twig');
// }

// if(isset($_POST['btn-signin']))
// {
//     $uname = strip_tags($_POST['txt_uname_email']);
//     $umail = strip_tags($_POST['txt_uname_email']);
//     $upass = strip_tags($_POST['txt_password']);

//     if($login->doLogin($uname,$umail,$upass))
//     {
//         $login->redirect('www/login.php');
//     }
//     else
//     {
//         $error = "Les infos sont incorrectes";
//     }   
// }


echo $twig->render('login.html.twig');