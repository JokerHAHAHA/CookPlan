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

if (isset($_POST['add-meal'])) {
$cat = $_GET['cat'];

    switch ($cat) {
        case 'UN APERITIF':
            $category = 'aperitif';
            break;
        case 'UNE ENTREE':
            $category = 'starter';
            break;
        case 'UN PLAT':
            $category = 'meal';
            break;
        case 'UN ACCOMPAGNEMENT':
            $category = 'garnish';
            break;
        case 'UN DESSERT':
            $category = 'dessert';
            break;
        case 'UNE BOISSON':
            $category = 'drink';
            break;
    }
    $resp = Meal::create($_POST['name'], $category, $_POST['type'], $_SESSION['user_session']);

    if ($resp) {
        echo $twig->render("addMeal.html.twig", array(
            'title'=>$_GET['cat'],
            'save' =>$_GET['cat']." DE PLUS"
            ));
    }
    else
    {
        echo $twig->render("addMeal.html.twig", array(
            'title'=>$_GET['cat'],
            'save' =>"IL Y A EU UN PROBLEME AVEC L'ENREGISTREMENT"
            ));
    }
}
else
{
    echo $twig->render("addMeal.html.twig", array('title'=>$_GET['cat']));
}
    





