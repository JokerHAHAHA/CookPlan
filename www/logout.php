<?php

session_start();

use CookPlan\Autoloader;
use CookPlan\Model\Database;
use CookPlan\Model\User;

//redirige vers index si no user dans $_SESSION sinon ne fait rien
include "session.php";

$user_logout = new USER();

if($user_logout->is_loggedin()!="")
{
	$user_logout->redirect('meals.php');
}
if(isset($_GET['logout']) && $_GET['logout']=="true")
{
	$user_logout->doLogout();
	$user_logout->redirect('../index.php');
}
