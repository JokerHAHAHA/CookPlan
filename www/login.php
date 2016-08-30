<?php

// session_start();

//load Twig
include_once('../twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../templates'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
  'cache' => false
  ));

// require '../src/Autoloader.php';
// Autoloader::require();
include '../src/Model/Database.php';
include '../src/Model/User.php';
$login = new User();

// if($login->is_loggedin()!="")
// {
//     echo "string";
//     $login->redirect('./meals.php');
// }

if(isset($_POST['btn-signin']))
{

    $uname = strip_tags($_POST['login']);
    $umail = strip_tags($_POST['login']);
    $upass = strip_tags($_POST['password']);

    if($login->doLogin($uname,$umail,$upass))
    {
        $login->redirect('meals.php');
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

