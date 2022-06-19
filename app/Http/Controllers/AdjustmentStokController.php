<?php

namespace App\Http\Controllers;

use App\AdjustmentStok;
use App\Medicines;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdjustmentStokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result = AdjustmentStok::all();
        return view('adjustmentStok.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $medicine = Medicines::where('is_entry', 1)
            ->get();
        $category = Categories::all();
        return view('adjustmentStok.create', compact('medicine', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        $year = date("Y");
        $month = date("m");

        $dataNota = AdjustmentStok::where('name', 'like', 'PS/' . $year . '/' . $month . "/%")
            ->get();

        $totalIndex = str_pad(strval(count($dataNota) + 1), 4, '0', STR_PAD_LEFT);


        $dataNota = new AdjustmentStok();
        $dataNota->name = 'PS/' . $year . '/' . $month . "/" . $totalIndex;
        $dataNota->tanggalDibuat = date("Y-m-d");
        $dataNota->description = $request->get('description');
        $dataNota->QuantityAwal =  $request->get('QuantityAwal');
        $dataNota->QuantityBaru = $request->get('QuantityBaru');
        $dataNota->Selisih = $request->get('QuantityBaru') - $request->get('QuantityAwal');
        $dataNota->medicines_id = $request->get('medicine');
        $dataNota->created_by = $user->id;
        $dataNota->created_on = date("Y-m-d h:i:s");
        $dataNota->updated_by = $user->id;
        $dataNota->updated_on = date("Y-m-d h:i:s");
        $dataNota->save();


        $idtransaction = DB::table('inventory_transaction')->insertGetId(
            array(
                'name' => 'PS/' . $year . '/' . $month . "/" . $totalIndex,
                'tanggalDibuat	' => date("Y-m-d"),
                'adjustment_stock_id' => $dataNota->id,
                'created_by' => $user->id,
                'created_on	' => date("Y-m-d"),
                'updated_by	' => $user->id,
                'updated_on	' => date("Y-m-d"),
            )
        );
        DB::table('inventory_transactionline')->insert(
            array(
                'inventory_transaction_id' => $idtransaction,
                'medicines_id	' => $request->get('medicine'),
                'jumlah' => $request->get('QuantityBaru') - $request->get('QuantityAwal'),
            )
        );
        return redirect()->route('adjustmentStok.index')->with('status', 'Success!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AdjustmentStok  $AdjustmentStok
     * @return \Illuminate\Http\Response
     */
    public function show(AdjustmentStok $AdjustmentStok)
    {
        //
        $medicine = Medicines::where('is_entry', 1)
            ->get();
        $category = Categories::all();
        return view('adjustmentStok.show', compact('medicine', 'category','AdjustmentStok'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdjustmentStok  $AdjustmentStok
     * @return \Illuminate\Http\Response
     */
    public function edit(AdjustmentStok $AdjustmentStok)
    {
        //
        $medicine = Medicines::where('is_entry', 1)
            ->get();
        $category = Categories::all();
        return view('adjustmentStok.edit', compact('medicine', 'category','AdjustmentStok'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdjustmentStok  $AdjustmentStok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdjustmentStok $AdjustmentStok)
    {
        //
        $user = Auth::user();

        $AdjustmentStok->description = $request->get('description');
        $AdjustmentStok->QuantityAwal =  $request->get('QuantityAwal');
        $AdjustmentStok->QuantityBaru = $request->get('QuantityBaru');
        $AdjustmentStok->Selisih = $request->get('QuantityBaru') - $request->get('QuantityAwal');
        $AdjustmentStok->medicines_id = $request->get('medicine');
        $AdjustmentStok->updated_by = $user->id;
        $AdjustmentStok->updated_on = date("Y-m-d h:i:s");
        $AdjustmentStok->save();

        $idIIT = DB::table('ItemInventoryTransaction')->select('id')->where('adjustment_stock_id', $AdjustmentStok->id)->get();
        DB::table('inventory_transactionline')
            ->where('inventory_transaction_id', $idIIT[0]->id)
            ->update(
                array(
                    'medicines_id	' => $request->get('medicine'),
                    'jumlah' => $request->get('quantity'),
                )
            );

        return redirect()->route('adjustmentStok.index')->with('status', 'Adjustment Stok diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdjustmentStok  $AdjustmentStok
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdjustmentStok $AdjustmentStok)
    {
        //
        $user = Auth::user();
        $idIIT = DB::table('ItemInventoryTransaction')->select('id')->where('adjustment_stock_id', $AdjustmentStok->id)->get();
        DB::table('ItemInventoryTransaction')
            ->where('adjustment_stock_id', $AdjustmentStok->id)
            ->delete();

        DB::table('ItemInventoryTransactionLine')
            ->where('inventory_transaction_id', $idIIT[0]->id)
            ->delete();

        $AdjustmentStok->delete();
    }
}
