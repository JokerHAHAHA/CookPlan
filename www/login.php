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
Autoloader::load();

$login = new User();

if($login->is_loggedin()!="")
{
    $login->redirect('./meals.php');
}

// SIGN IN
if(isset($_POST['btn-signin']))
{
    $name = strip_tags($_POST['login']);
    $email = strip_tags($_POST['login']);
    $password = strip_tags($_POST['password']);

    if($login->doLogin($name,$email,$password))
    {
        header("Location: meals.php");
    }
    else
    {
        echo $twig->render('login.html.twig', array('errorSignin' => "Les informations sont incorrectes"));
    }   
}
// SIGN UP
else if(isset($_POST['btn-signup']))
{
    $login = strip_tags($_POST['login']);
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);   
    
    if($login=="")
    {
        $error['login'] = "merci de renseigner votre pseudo";
        echo $twig->render('login.html.twig', array('errorSignup'=>$error));    
    }
    else if($email=="")
    {
        $error['email'] = "merci de renseigner votre address mail";
        echo $twig->render('login.html.twig', array('errorSignup'=>$error));     
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error['email'] = 'entrez une adresse mail valide';
        echo $twig->render('login.html.twig', array('errorSignup'=>$error)); 
    }
    else if($password=="")
    {
        $error['password'] = "merci de renseigner un mot de passe";
        echo $twig->render('login.html.twig', array('errorSignup'=>$error)); 
    }
    else if(strlen($password) < 6)
    {
        $error['password'] = "votre mot de passe doit avoir au moins 6 caratarères,
                                sinon on va vous piquer vos recettes : Pirates !";
        echo $twig->render('login.html.twig', array('errorSignup'=>$error));  
    }
    else
    {
        $resp = User::register($login,$email,$password);
        if(is_array($resp))
        {
            echo $twig->render('login.html.twig', array('errorSignup'=>$resp));
        }
        else
        {
            header("Location: meals.php");
        }
    }   
}
else
{
    echo $twig->render('login.html.twig');
}












