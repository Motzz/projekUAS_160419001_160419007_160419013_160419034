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

        $user = Auth::user();
        if($user->role == "admin"){
            return view('adjustmentStok.index', compact('result'));
        }else{
            return redirect('/')->with('status','Tidak dapat mengakses halaman Admin');
        }
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

        /*$dataReport = DB::table('inventory_transactionline') //dibuat untuk check barang di gudang tersebut apaan yang perlu dibeneri stok nya
            ->select(
                'inventory_transactionline.medicines_id',DB::raw("sum(inventory_transactionline.jumlah) as totalQuantity")
            )
            ->groupBy('inventory_transactionline.medicines_id')
            ->get();*/
        $dataReport = DB::table('inventory_transactionline') //dibuat untuk check barang di gudang tersebut apaan yang perlu dibeneri stok nya
            ->select('inventory_transactionline.medicines_id',"inventory_transactionline.jumlah")
            ->get();

            
        $user = Auth::user();
        if($user->role == "admin"){
            return view('adjustmentStok.create', compact('medicine', 'category','dataReport'));
        }else{
            return redirect('/')->with('status','Tidak dapat mengakses halaman Admin');
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
        //
        $user = Auth::user();
        $year = date("Y");
        $month = date("m");

        $dataNota = AdjustmentStok::where('name', 'like', 'PS/' . $year . '/' . $month . "/%")
            ->get();

        $totalIndex = str_pad(strval(count($dataNota) + 1), 4, '0', STR_PAD_LEFT);


        $dataNota = new AdjustmentStok();
        $dataNota->name = 'PS/' . $year . '/' . $month . "/" . $totalIndex;
        $dataNota->tanggalDibuat = date("Y-m-d");//apo
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
                'tanggalDibuat' => date("Y-m-d"),
                'adjustment_stock_id' => $dataNota->id,
                'created_by' => $user->id,
                'created_on' => date("Y-m-d"),
                'updated_by' => $user->id,
                'updated_on' => date("Y-m-d"),
            )
        );
        DB::table('inventory_transactionline')->insert(
            array(
                'inventory_transaction_id' => $idtransaction,
                'medicines_id' => $request->get('medicine'),
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

        $user = Auth::user();
        if($user->role == "admin"){
            return view('adjustmentStok.show', compact('medicine', 'category','AdjustmentStok'));
        }else{
            return redirect('/')->with('status','Tidak dapat mengakses halaman Admin');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdjustmentStok  $AdjustmentStok
     * @return \Illuminate\Http\Response
     */
    public function edit(AdjustmentStok $adjustmentStok)
    {
        //
        $medicine = Medicines::where('is_entry', 1)
            ->get();
        $category = Categories::all();

        $dataReport = DB::table('inventory_transactionline') //dibuat untuk check barang di gudang tersebut apaan yang perlu dibeneri stok nya
            ->select(
                'inventory_transactionline.medicines_id',"inventory_transactionline.jumlah"
            )
            ->join('inventory_transaction', 'inventory_transactionline.inventory_transaction_id', '=', 'inventory_transaction.id')
            ->where('inventory_transaction.adjustment_stock_id','!=', $adjustmentStok->id)
            ->get();

        //dd($dataReport);
        $user = Auth::user();
        if($user->role == "admin"){
            return view('adjustmentStok.edit', compact('medicine', 'category','adjustmentStok', 'dataReport'));
        }else{
            return redirect('/')->with('status','Tidak dapat mengakses halaman Admin');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdjustmentStok  $AdjustmentStok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdjustmentStok $adjustmentStok)
    {
        //
        $user = Auth::user();

        $adjustmentStok->description = $request->get('description');
        $adjustmentStok->QuantityAwal =  $request->get('QuantityAwal');
        $adjustmentStok->QuantityBaru = $request->get('QuantityBaru');
        $adjustmentStok->Selisih = $request->get('QuantityBaru') - $request->get('QuantityAwal');
        $adjustmentStok->medicines_id = $request->get('medicine');
        $adjustmentStok->updated_by = $user->id;
        $adjustmentStok->updated_on = date("Y-m-d h:i:s");
        $adjustmentStok->save();

        $idIIT = DB::table('inventory_transaction')->select('id')->where('adjustment_stock_id', $adjustmentStok->id)->get();
        DB::table('inventory_transactionline')
            ->where('inventory_transaction_id', $idIIT[0]->id)
            ->update(
                array(
                    'medicines_id' => $request->get('medicine'),
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
    public function destroy(AdjustmentStok $adjustmentStok)
    {
        //
        $user = Auth::user();
        $idIIT = DB::table('inventory_transaction')->select('id')->where('adjustment_stock_id', $adjustmentStok->id)->get();
        DB::table('inventory_transaction')
            ->where('adjustment_stock_id', $adjustmentStok->id)
            ->delete();

        DB::table('inventory_transactionline')
            ->where('inventory_transaction_id', $idIIT[0]->id)
            ->delete();

        $adjustmentStok->delete();
    }
}
