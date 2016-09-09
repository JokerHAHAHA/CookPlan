<?php

session_start();

use CookPlan\Autoloader;
use CookPlan\Model\Database;
use CookPlan\Model\User;
use CookPlan\Model\Meal;
use CookPlan\Model\Planning;

//load Twig
include_once('../twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../templates'); // Dossier contenant les templates
$twig = new Twig_Environment($loader, array(
  'cache' => false
  ));

require '../src/Autoloader.php';
Autoloader::load();

$auth_user = new User();
//load datas
$currentUser_id = $_SESSION['user_session'];
$user = User::findOne($currentUser_id);
$meals = Meal::findAll($currentUser_id);

//check if connected
if($auth_user->is_loggedin())
{

    //manage logout
    if(isset($_POST['btn-signout']))
    {
        $auth_user->doLogout();
        $auth_user->redirect('../index.php');
    }
    //manage schedule
    else if(isset($_POST['btn-planning']))
    {
        $duration = $_GET['duration'];

        $planning = Planning::createPlanning($meals, $duration, $user['user_id']);

        echo $twig->render('planning.html.twig', array(
            'user'    =>$user,
            'planning'=>$planning
            ));
    }
    else
    {
        $planning = Planning::findOne(6,3);
        // var_dump($Planning);die;
        echo $twig->render('planning.html.twig', array(
            'user'    =>$user,
            'planning'=>$planning
            ));
    }

}
else
{
    $auth_user->redirect('../index.php');
}