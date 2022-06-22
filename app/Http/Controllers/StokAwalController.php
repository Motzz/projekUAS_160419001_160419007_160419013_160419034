<?php

namespace App\Http\Controllers;

use App\StokAwal;
use App\Medicines;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StokAwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result = StokAwal::all();
        return view('stokAwal.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $medicine = Medicines::where('is_entry', 0)
            ->get();
        $category = Categories::all();
        return view('stokAwal.create', compact('medicine', 'category'));
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

        $dataNota = StokAwal::where('name', 'like', 'SA/' . $year . '/' . $month . "/%")
            ->get();

        $totalIndex = str_pad(strval(count($dataNota) + 1), 4, '0', STR_PAD_LEFT);


        $dataNota = new StokAwal();
        $dataNota->name = 'SA/' . $year . '/' . $month . "/" . $totalIndex;
        $dataNota->tanggalDibuat = date("Y-m-d"); //ini di html readonly diseting tanggal skrg kusus di store aja kalo edit ambil dri db   1  
        $dataNota->jumlah =  $request->get('jumlah'); //ini di html dibuat numbe
         
        $dataNota->description = $request->get('description'); //ini di html dibuat textbox    4 
        $dataNota->medicines_id = $request->get('medicine'); //ini di html dibuat combobox    2 
        $dataNota->created_by = $user->id;
        $dataNota->created_on = date("Y-m-d h:i:s");
        $dataNota->updated_by = $user->id;
        $dataNota->updated_on = date("Y-m-d h:i:s");
        $dataNota->save();

        $obatDipilih = Medicines::find($request->get('medicine'));
        $obatDipilih->is_entry = 1;
        $obatDipilih->save();


        $idtransaction = DB::table('inventory_transaction')->insertGetId(
            array(
                'name' => 'SA/' . $year . '/' . $month . "/" . $totalIndex,
                'tanggalDibuat' => date("Y-m-d"),
                'stock_awal_id' => $dataNota->id,
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
                'jumlah' => $request->get('quantity'),
            )
        );
        return redirect()->route('stokAwal.index')->with('status', 'Success!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StokAwal  $stokAwal
     * @return \Illuminate\Http\Response
     */
    public function show(StokAwal $stokAwal)
    {
        //
        $medicine = Medicines::where('is_entry', 0)
            ->orWhere('id', $stokAwal->medicines_id)
            ->get();
        $category = Categories::all();
        return view('stokAwal.show', compact('medicine', 'category', 'stokAwal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StokAwal  $stokAwal
     * @return \Illuminate\Http\Response
     */
    public function edit(StokAwal $stokAwal)
    {
        //
        $medicine = Medicines::where('is_entry', 0)
            ->get();
        $category = Categories::all();
        return view('stokAwal.edit', compact('medicine', 'category', 'stokAwal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StokAwal  $stokAwal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StokAwal $stokAwal)
    {
        //
        $user = Auth::user();

        $stokAwal->tanggalDibuat = date("Y-m-d");
        $stokAwal->jumlah =  $request->get('jumlah');
        $stokAwal->description = $request->get('description');
        $stokAwal->medicines_id = $request->get('medicine');
        $stokAwal->updated_by = $user->id;
        $stokAwal->updated_on = date("Y-m-d h:i:s");
        $stokAwal->save();

        $obatDipilihSebelum = Medicines::find($stokAwal->medicines_id);
        $obatDipilihSebelum->is_entry = 0;
        $obatDipilihSebelum->save();

        $obatDipilih = Medicines::find($request->get('medicine'));
        $obatDipilih->is_entry = 1;
        $obatDipilih->save();

        $idIIT = DB::table('ItemInventoryTransaction')->select('id')->where('stock_awal_id', $stokAwal->id)->get();
        DB::table('inventory_transactionline')
            ->where('inventory_transaction_id', $idIIT[0]->id)
            ->update(
                array(
                    'medicines_id' => $request->get('medicine'),
                    'jumlah' => $request->get('quantity'),
                )
            );

        return redirect()->route('stokAwal.index')->with('status', 'Supplier diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StokAwal  $stokAwal
     * @return \Illuminate\Http\Response
     */
    public function destroy(StokAwal $stokAwal)
    {
        //
        $user = Auth::user();

        $obatDipilihSebelum = Medicines::find($stokAwal->medicines_id);
        $obatDipilihSebelum->is_entry = 0;
        $obatDipilihSebelum->save();

        $idIIT = DB::table('ItemInventoryTransaction')->select('id')->where('stock_awal_id', $stokAwal->id)->get();
        DB::table('ItemInventoryTransaction')
            ->where('stock_awal_id', $stokAwal->id)
            ->delete();

        DB::table('ItemInventoryTransactionLine')
            ->where('inventory_transaction_id', $idIIT[0]->id)
            ->delete();

        $stokAwal->delete();
        return redirect()->route('stokAwal.index')->with('status', 'Supplier dihapus');
    }
}
