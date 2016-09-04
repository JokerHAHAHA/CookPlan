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

//check if connected
if($auth_user->is_loggedin())
{
    //manage logout
    if(isset($_POST['btn-signout']))
    {
        $auth_user->doLogout();
        $auth_user->redirect('../index.php');
    }
    //manage update meal
    else if (isset($_POST['update-meal']))
    {
        $resp = Meal::create($_POST['name'], $category, $_POST['type'], $_SESSION['user_session']);

        if ($resp)
        {
            //load datas
            $currentUser_id = $_SESSION['user_session'];
            $user = User::findOne($currentUser_id);
            echo $twig->render("addMeal.html.twig", array(
                'user' =>$user,
                'title'=>$_GET['cat'],
                'msg' =>$_GET['cat']." DE PLUS"
                ));
        }
        else
        {
            //load datas
            $currentUser_id = $_SESSION['user_session'];
            $user = User::findOne($currentUser_id);
            echo $twig->render("addMeal.html.twig", array(
                'title'=>$_GET['cat'],
                'msg'  =>"IL Y A EU UN PROBLEME AVEC L'ENREGISTREMENT"
                ));
        }
    }
    //normal load
    else
    {
        //load datas
        $currentUser_id = $_SESSION['user_session'];
        $user = User::findOne($currentUser_id);
        $meal_id = $_GET['target'];
        $meal = Meal::findOne($meal_id);
        echo $twig->render("updateMeal.html.twig", array(
            'user' =>$user,
            'meal' =>$meal
            ));
    }
}
//if not logged
else
{
    $auth_user->redirect('../index.php');
}






