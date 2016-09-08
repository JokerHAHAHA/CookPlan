<?php

namespace CookPlan\Model;
use CookPlan\Model\Database;

Class Planning
{
    public static function createPlanning($meals, $duration, $user)
    {
        //stock each categories
        $aperitifs = array();
        $starters = array();
        $meats = array();
        $garnishes = array();
        $desserts = array();
        $drinks = array();
        //stock already in the planning
        $used_id = array();
        //stock le planning a retouner
        $planning = array();

        //seperate categories
        foreach ($meals as $meal) {
            if($meal['category']=='aperitif'){
                array_push($aperitifs, $meal);
            }
            if($meal['category']=='starter'){
                array_push($starters, $meal);
            }
            if($meal['category']=='meal'){
                array_push($meats, $meal);
            }
            if($meal['category']=='garnish'){
                array_push($garnishes, $meal);
            }
            if($meal['category']=='dessert'){
                array_push($desserts, $meal);
            }
            if($meal['category']=='drink'){
                array_push($drinks, $meal);
            }
        }

        //turn on chosen number of days
        for ($day=0; $day < $duration; $day++) {
            //make 2 menus per day
            for ($menu=0; $menu < 2; $menu++) { 

                $planned_date = time() + ($day * 3600 * 24);
                //APERITIF
                $targetAperitif = self::getRandomIndex(0, sizeof($aperitifs)-1, $aperitifs, $used_id);
                //keep id of aperitif used
                array_push($used_id, $aperitifs[$targetAperitif]['id']);
                $planning[$day][$menu]['aperitif'] = $aperitifs[$targetAperitif];
                self::createPlanned($aperitifs[$targetAperitif], $planned_date, $menu, $user);

                //STARTER
                $targetStarter = self::getRandomIndex(0, sizeof($starters)-1, $starters, $used_id);
                //keep id of starter used
                array_push($used_id, $starters[$targetStarter]['id']);
                $planning[$day][$menu]['starter'] = $starters[$targetStarter];
                self::createPlanned($starters[$targetStarter], $planned_date, $menu, $user);

                //MEAT
                $targetMeat = self::getRandomIndex(0, sizeof($meats)-1, $meats, $used_id);
                //keep id of meat used
                array_push($used_id, $meats[$targetMeat]['id']);
                $planning[$day][$menu]['meat'] = $meats[$targetMeat];
                self::createPlanned($meats[$targetMeat], $planned_date, $menu, $user);

                //GARNISH
                $targetGarnish = self::getRandomIndex(0, sizeof($garnishes)-1, $garnishes, $used_id);
                //keep id of garnish used
                array_push($used_id, $garnishes[$targetGarnish]['id']);
                $planning[$day][$menu]['garnish'] = $garnishes[$targetGarnish];
                self::createPlanned($garnishes[$targetGarnish], $planned_date, $menu, $user);

                //DESSERT
                $targetDessert = self::getRandomIndex(0, sizeof($desserts)-1, $desserts, $used_id);
                //keep id of dessert used
                array_push($used_id, $desserts[$targetDessert]['id']);
                $planning[$day][$menu]['dessert'] = $desserts[$targetDessert];
                self::createPlanned($desserts[$targetDessert], $planned_date, $menu, $user);

                //DRINK
                $targetDrink = self::getRandomIndex(0, sizeof($drinks)-1, $drinks, $used_id);
                //keep id of drink used
                array_push($used_id, $drinks[$targetDrink]['id']);
                $planning[$day][$menu]['drink'] = $drinks[$targetDrink];
                self::createPlanned($drinks[$targetDrink], $planned_date, $menu, $user);
            
            }//end for menu 
        }//end for day

        return $planning;
    }//end function makePlanning

    public static function createPlanned($meal, $planned_date, $menu, $user)
    {
        $conn = new Database();
        $conn = $conn->dbConnection();
        $sql  = "INSERT INTO planning(planned_date,menu,user,meal_id,meal_name,meal_category,meal_type)
                 VALUES (:planned_date,:menu,:user,:meal_id,:meal_name,:meal_category,:meal_type)";
        $stmt = $conn->prepare($sql);
        $stmt->bindparam(":planned_date", $planned_date);
        $stmt->bindparam(":menu", $menu);
        $stmt->bindparam(":user", $user);                                        
        $stmt->bindparam(":meal_id", $meal['id']);                                        
        $stmt->bindparam(":meal_name", $meal['name']);                                        
        $stmt->bindparam(":meal_category", $meal['category']);                                        
        $stmt->bindparam(":meal_type", $meal['type']);                                        
        $stmt->execute();
        return $stmt;
    }

    public static function findOne($duration, $user)
    {
        $today = date('w');
        $dayToSeconds = 3600 * 24;
        $startPlanning = time() - (($today * $dayToSeconds) - $dayToSeconds);
        $end = $startPlanning + ($duration * $dayToSeconds);


        $conn = new Database();
        $conn = $conn->dbConnection();
        $sql = "SELECT * FROM planned
                WHERE user=:user 
                AND planned_date >= :startPlanning 
                AND planned_date <= :endPlanning";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(
            ":user"          =>$user,
            ":startPlanning" =>$startPlanning,
            ":endPlanning"   =>$end));
        $meals = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        for ($day=0; $day = $duration ; $day++)
        { 
            for ($menu=0; $menu < 2; $menu++)
            { 
                foreach ($meals as $meal)
                {
                    if ($meal['menu'] == $menu && date('d/m/Y',$meal['planned_date'] == date('d/m/Y', $startPlanning + ($day * $dayToSeconds))))
                    {
                        $planning[$day][$menu][$meal['category']] = $meal;
                    }
                }
            }
        }

        return $planning;

    }

    public static function getRandomIndex($min, $max, $category, $used_id)
    {
        $index = rand($min, $max);
        if(in_array($meats[$category]['id'], $used_id))
        {
            getRandomIndex($min, $max, $used_id);
        }
        else
        {
            return $index;
        }
    }
}