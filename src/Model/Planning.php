<?php

namespace CookPlan\Model;
use CookPlan\Model\Database;

Class Planning
{
    public static function makePlanning($meals, $duration)
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
                
                //APERITIF
                $targetAperitif = self::getRandomIndex(0, sizeof($aperitifs)-1, $aperitifs, $used_id);
                //keep id of aperitif used
                array_push($used_id, $aperitifs[$targetAperitif]['id']);
                $planning[$day][$menu]['aperitif'] = $aperitifs[$targetAperitif];

                //STARTER
                $targetStarter = self::getRandomIndex(0, sizeof($starters)-1, $starters, $used_id);
                //keep id of starter used
                array_push($used_id, $starters[$targetStarter]['id']);
                $planning[$day][$menu]['starter'] = $starters[$targetStarter];

                //MEAT
                $targetMeat = self::getRandomIndex(0, sizeof($meats)-1, $meats, $used_id);
                //keep id of meat used
                array_push($used_id, $meats[$targetMeat]['id']);
                $planning[$day][$menu]['meat'] = $meats[$targetMeat];

                //GARNISH
                $targetGarnish = self::getRandomIndex(0, sizeof($garnishes)-1, $garnishes, $used_id);
                //keep id of garnish used
                array_push($used_id, $garnishes[$targetGarnish]['id']);
                $planning[$day][$menu]['garnish'] = $garnishes[$targetGarnish];

                //DESSERT
                $targetDessert = self::getRandomIndex(0, sizeof($desserts)-1, $desserts, $used_id);
                //keep id of dessert used
                array_push($used_id, $desserts[$targetDessert]['id']);
                $planning[$day][$menu]['dessert'] = $desserts[$targetDessert];

                //DRINK
                $targetDrink = self::getRandomIndex(0, sizeof($drinks)-1, $drinks, $used_id);
                //keep id of drink used
                array_push($used_id, $drinks[$targetDrink]['id']);
                $planning[$day][$menu]['drink'] = $drinks[$targetDrink];
            
            }//end for menu 
        }//end for day

        return $planning;
    }//end function makePlanning

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