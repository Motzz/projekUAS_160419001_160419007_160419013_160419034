<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Medicines;
use App\Categories;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result = Transaction::all();
        return view('transaction.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $medicine = Medicines::all();
        $category = Categories::all();
        return view('transaction.create', compact('medicine', 'category'));
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

        $dataNota = Transaction::where('name', 'like', 'NT/'. $year . '/' . $month . "/%")
            ->get();

        $totalIndex = str_pad(strval(count($dataNota) + 1), 4, '0', STR_PAD_LEFT);


        $dataNota = new Transaction();
        $dataNota->name = 'NT/'. $year . '/' . $month . "/". $totalIndex;
        $dataNota->transaction_date = date("Y-m-d");
        $dataNota->user_id = $user->id;
        $dataNota->created_by = $user->id;
        $dataNota->created_on = date("Y-m-d h:i:s");
        $dataNota->updated_by = $user->id;
        $dataNota->updated_on = date("Y-m-d h:i:s");
        $dataNota->save();

        $totalHargaSeluruh = 0;
        for ($i = 0; $i < count($request->get('medicine')); $i++) {
            DB::table('medicine_transaction')->insert(
                array(
                    'quantity' => $request->get('quantity')[$i],
                    'price' => $request->get('price')[$i],
                    'transaction_id' => $dataNota->id,
                    'medicines_id' => $request->get('medicine')[$i],
                    'totalprice	' => $request->get('quantity')[$i] * $request->get('price')[$i],
                )
            );
            $totalHargaSeluruh = $totalHargaSeluruh + $request->get('quantity')[$i] * $request->get('price')[$i];
        }

        $notaDipilih = Transaction::find($dataNota->id);
        $notaDipilih->total = $totalHargaSeluruh;
        $notaDipilih->save();

        $idtransaction = DB::table('inventory_transaction')->insertGetId(
            array(
                'name' => 'NT/'. $year . '/' . $month . "/". $totalIndex,
                'tanggalDibuat	' => date("Y-m-d"),
                'transaction_id	' => $dataNota->id,
                'created_by' => $user->id,
                'created_on	' => date("Y-m-d"),
                'updated_by	' => $user->id,
                'updated_on	' => date("Y-m-d"),
            )
        );
        for ($i = 0; $i < count($request->get('medicine')); $i++) {
            DB::table('inventory_transactionline')->insert(
                array(
                    'inventory_transaction_id' => $idtransaction,
                    'medicines_id	' => $request->get('medicine')[$i],
                    'jumlah' => $request->get('quantity')[$i] * -1,
                )
            );
            $totalHargaSeluruh = $totalHargaSeluruh + $request->get('quantity')[$i] * $request->get('price')[$i];
        }

        return redirect()->route('transaction.index')->with('status','Success!!');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
        $medicine = Medicines::all();
        $category = Categories::all();
        $user = Auth::user();
        return view('transaction.create', compact('medicine', 'category', 'transaction','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
