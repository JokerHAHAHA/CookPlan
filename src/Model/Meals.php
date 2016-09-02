<?php

namespace CookPlan\Model;
use CookPlan\Model\Database;

Class Meal
{
    private $id;
    private $name;
    private $date_creation;
    private $category;
    private $type;
    private $user;

    public static function findAll($user) {
        $conn = new Database();
        $conn = $conn->dbConnection();
        $sql  = "SELECT * FROM meals WHERE user=:user";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(":user"=>$user));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name,$category,$type,$user) {
        $conn = new Database();
        $conn = $conn->dbConnection();
        $sql  = "INSERT INTO meals
                 VALUES (:name,:category,:type,:user";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":name"=>$name,
            ":category"=>$category,
            ":type"=>$type,
            ":user"=>$user
            ));
        return true;
    }

    public static function update($id,$name,$category,$type) {
        $conn = new Database();
        $conn = $conn->dbConnection();
        $sql  = "UPDATE meals
                 SET name=:name, category=:category, type=:type
                 WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":id"=>$id,
            ":name"=>$name,
            ":category"=>$category,
            ":type"=>$type,
            ));
        return true;
    }
}
