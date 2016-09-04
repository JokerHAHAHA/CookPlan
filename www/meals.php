<?php

session_start();

use CookPlan\Autoloader;
use CookPlan\Model\Database;
use CookPlan\Model\User;
use CookPlan\Model\Meal;

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

$auth_user = new User();
//load datas
$currentUser_id = $_SESSION['user_session'];
$user = User::findOne($currentUser_id);
$meals = Meal::findAll($_SESSION['user_session']);

//check if connected
if($auth_user->is_loggedin())
{

    //manage logout
    if(isset($_POST['btn-signout']))
    {
        $auth_user->doLogout();
        $auth_user->redirect('../index.php');
    }
    //manage delete
    else if(isset($_POST['btn-delete']))
    {
        //delete meal
        $meal_id = $_GET['target'];
        Meal::delete($meal_id);
        //reload datas
        $meals = Meal::findAll($user['user_id']);
        echo $twig->render('meals.html.twig', array(
            'user' =>$user,
            'meals'=>$meals
            ));
    }
    else
    {
        echo $twig->render('meals.html.twig', array(
            'user' =>$user,
            'meals'=>$meals
            ));
    }

}
else
{
    $auth_user->redirect('../index.php');
}