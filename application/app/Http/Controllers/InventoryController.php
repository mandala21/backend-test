<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InventoryTradeRequest;
use App\Helper\ItensValue;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
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
     * Make trade item between survivor
     * @param App\Http\Requests\InventoryChangeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function makeTrade(InventoryTradeRequest $request){
        $data = $request->all();
        #calcule price of exchanger itens
        foreach ($data['exchanger']['itens'] as $item) {
            dd(ItensValue::getValue($item['item']));
        }
    }
}
