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
        $target_id = $_GET['target'];
        $target_name = $_POST['name'];
        $target_category = Meal::findOne($target_id)['category'];
        $target_type = $_POST['type'];
        $resp = Meal::update($target_id, $target_name, $target_category, $target_type);

        if ($resp)
        {
            //redirect
            $auth_user->redirect('./meals.php');
        }
        else
        {
            //load datas
            $currentUser_id = $_SESSION['user_session'];
            $user = User::findOne($currentUser_id);
            echo $twig->render("addMeal.html.twig", array(
                'meal' =>$meal,
                'msg'  =>"IL Y A EU UN PROBLEME AVEC LA MODIFICATION"
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






