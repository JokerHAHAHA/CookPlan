<?php

session_start();
use Cookplan\Model\User;
include_once('../twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
	'cache' => false
	));


if(!$session->is_loggedin())
{
	// session no set redirects to login page
	$session->redirect('login.php');
}