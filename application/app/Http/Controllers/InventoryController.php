<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InventoryTradeRequest;
use App\Http\Requests\InventoryCreateRequest;
use App\Helper\ItensValue;
use App\Inventory;
use App\Survivor;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($survivor_id)
    {
        $survivor = Survivor::find($survivor_id);
        if ($survivor){
            if($survivor->isInfected()){
                return response()->json(['message'=>'Survivor is infected'],400);
            }
            //list all itens of survivor
            return response()->json($survivor->inventory->toArray());
        } else {
            return response()->json(['message'=>'survivor not found'],404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $survivor = Survivor::find($data['survivor_id']);
            if ($survivor){
                //check if is infected
                if($survivor->isInfected()){
                    return response()->json(['message'=>'Survivor infected dont change your inventory'],400);
                }
                //for each item create for survivor inventory
                foreach ($data['itens'] as $item) {
                    $survivor->inventory()->create($item);
                }
            } else{
                //dont find
                return response()->json(['message'=>'Survivor not found'],404);
            }
            DB::commit();
            return response()->json($survivor->inventory(),201);
        } catch (\Throwable $th){
            DB::rollBack();
            return response()->json(['message'=>'Error in process'],500);
        }
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
    public function destroy($survivor_id,$item_id)
    {
        $survivor = Survivor::find($survivor_id);
        if ($survivor){
            if($survivor->isInfected()){
                return response()->json(['message'=>'Survivor infected dont change in your inventory'],404);
            }
            //retrive item and check if survivor is owner 
            $item = $survivor->inventory()->where('id',$item_id)->first();
            if ($item){
                $item->delete();
                return response()->json([],204);
            } else {
                return response()->json(['message'=>'item dont exists or dont owned by survivor'],404);
            }
            
        } else {
            return response()->json(['message'=>'Survivor dont find'],404);
        }
    }

    /**
     * Make trade item between survivor
     * @param App\Http\Requests\InventoryChangeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function makeTrade(InventoryTradeRequest $request){
        try{
            DB::beginTransaction();
            $data = $request->all();
            $totalExchanger = 0;
            $totalRecipient = 0;
            $exchanger = Survivor::find($data['exchanger']['survivor_id']);
            $recipient = Survivor::find($data['recipient']['survivor_id']);
            if(!$exchanger or !$recipient){
                return response()->json(['message'=>'Exchanger or recipient not found'],404);
            } else {
                //check if dont infected
                if ($exchanger->isInfected() or $recipient->isInfected()){
                    return response()->json(['message'=>'Exchanger or recipient infected'],400);
                }
            }

            //calcule price of exchanger itens
            foreach ($data['exchanger']['itens'] as $item) {
                //get item of db
                $itemDB = $exchanger->inventory()->where('id',$item['id'])->first();
                //have item?
                if ($itemDB){
                    if ($itemDB->ammount == $item['ammount']){
                        //if trade all, just trade owner 
                        $itemDB->survivor_id = $data['recipient']['survivor_id'];
                    } else if ($itemDB->ammount > $item['ammount']){
                        //if smaller so decreases amount and create new for recipient
                        $itemDB->ammount -= $item['ammount'];
                        $item['item'] = $itemDB->item; //add item
                        $recipient->inventory()->create($item);
                    } else {
                        //if bigger ammount, dont make trade
                        DB::rollBack();
                        return response()->json(['message'=>'One item bigger of current ammount'],400);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['message'=>'Item of exchange not found'],404);
                }
                $price = $itemDB->item;
                $totalExchanger += $price * $item['ammount'];
                $itemDB->save();
            }
            //calcule price of recipient
            foreach ($data['recipient']['itens'] as $item ) {
                //get item of db
                $itemDB = $recipient->inventory()->where('id',$item['id'])->first();
                //have item?
                if ($itemDB){
                    if ($itemDB->ammount == $item['ammount']){
                        //if trade all, just trade owner 
                        $itemDB->survivor_id = $data['exchanger']['survivor_id'];
                    } else if ($itemDB->ammount > $item['ammount']){
                        //if smaller so decreases amount and create new for recipient
                        $itemDB->ammount -= $item['ammount'];
                        $item['item'] = $itemDB->item; //add item
                        $exchanger->inventory()->create($item);
                    } else {
                        //if bigger ammount, dont make trade
                        DB::rollBack();
                        return response()->json(['message'=>'One item bigger of current ammount'],400);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['message'=>'Item of recipient not found'],404);
                }
                $price = $itemDB->item;
                $totalRecipient += $price * $item['ammount'];
                $itemDB->save();
            }

            //check if trade is valid
            if($totalExchanger!=$totalRecipient){
                DB::rollBack();
                return response()->json(['message'=>'The prices is not equals'],400);
            } else {
                //make trade
                DB::commit();
                return response()->json(['message'=>'Success'],200);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return response()->json(['message'=>'error in process'],500);
        }
    }
}
