<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survivor as Survivor;
use App\AlertInfected;
use App\Http\Requests\SurvivorRequest;
use App\Http\Requests\MarkInfectedRequest;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class SurvivorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //list all not infected survivor
        $all = Survivor::allNotInfected()->get();
        //returns json 200
        return response()->json($all,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\SurvivorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurvivorRequest $request)
    {
        //init transaction garants atomic request
        try {
            DB::beginTransaction();
                //create surviver
                $data = $request->all();
                $survivor = Survivor::create($data);
                //create itens of inventory
                foreach ($data['inventory'] as $inventoryData) {
                    $survivor->inventory()->create($inventoryData);
                }
            DB::commit();
        } catch (\Throwable $th) {
            //something wrongs rollback transaction
            DB::rollBack();
            return response()->json(['message'=>'Error in process :('],500);
        }
        //return the object created
        return response()->json($survivor,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Add one alert that the survivor is infected
     * @param App\Http\Requests\MarkInfectedRequest $request
     * @return \Illuminate\Http\Response
     */
    public function markInfected(MarkInfectedRequest $request){
        $data = $request->all();
        //check if has reported
        $reported = AlertInfected::where([
            ['reporter_id','=',$data['reporter_id']],
            ['survivor_id','=',$data['survivor_id']],
        ])->count();
        //the survivor dont reported the aim
        if ($reported == 0){
            $alert = AlertInfected::create($request->all());
        } else {
            return response()->json(['message'=>'The survivor has been reported for you'],400);
        }

        return response()->json($alert,201);
    }
}
