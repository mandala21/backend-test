<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survivor;
use Illuminate\Support\Facades\DB;
use App\Inventory;

class ReportController extends Controller
{
    /**
     * Return the statitics of population
     * @return \Illuminate\Http\Response
     */
    public function population(){
        //count
        $allSurvivors = Survivor::all()->count();
        $allNotInfectedSurvivors = Survivor::allNotInfected()->count();
        $infectedSurvivors = $allSurvivors - $allNotInfectedSurvivors;
        //calc percetagem
        $percentInfected = round(($infectedSurvivors/$allSurvivors)*100,2);
        $percentNonInfected = 100 - $percentInfected;
        
        return response()->json([
            'infecteds'=>$percentInfected,
            'nonInfecteds'=>$percentNonInfected,
        ],200);
    }

    /**
     * Return the avarage ammoun of item by population
     * @return \Illuminate\Http\Response
     */

    public function itens(){
        //default values
        $rs = [];
        //dont include infected they is dead :(
        $allSurvivors = Survivor::allNotInfected()->count();
        //get all itens of survivor alive
        $allItens = $allItens = DB::table('survivor')
                        ->select('item',DB::raw('SUM(ammount) as total'))
                        ->join('inventory','survivor.id','=','inventory.survivor_id')
                        ->whereRaw('(select count(*) from "alert_infected" where "survivor"."id" = "alert_infected"."survivor_id") < 3')
                        ->groupBy('item')
                        ->get()
                        ->toArray();
        
        //calculate avarage
        foreach ($allItens as $item) {
            //label
            $label = Inventory::getHumanItem($item->item);
            //ammout by survivor
            $medium = round($item->total/$allSurvivors,2);
            array_push($rs,[$label=>$medium]);
        }
        return response()->json($rs,200);
    }

    /**
     * Return the avarage ammoun of item by population
     * @return \Illuminate\Http\Response
     */
    public  
}