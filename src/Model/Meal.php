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
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function create($name,$category,$type,$user) {
        $conn = new Database();
        $conn = $conn->dbConnection();
        $sql  = "INSERT INTO meals(name,category,type,user)
                 VALUES (:name,:category,:type,:user)";
        $stmt = $conn->prepare($sql);
        $stmt->bindparam(":name", $name);
        $stmt->bindparam(":category", $category);
        $stmt->bindparam(":type", $type);                                        
        $stmt->bindparam(":user", $user);                                        
                
        $stmt->execute();
  
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
    public static function delete($id) {
        $conn = new Database();
        $conn = $conn->dbConnection();
        $sql  = "DELETE FROM meals
                 WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":id"=>$id,
            ));
        return $stmt;
    }
}
