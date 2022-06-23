<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\InventoryTransaction;
use App\Medicines;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        $result = null;
        if($user->role == "buyer"){
            $result = Transaction::where('user_id',$user->id)
                ->orderBy('id', 'DESC')    
                ->orderBy('transaction_date', 'DESC')
                ->get();
        }
        else if($user->role == "admin"){
            $result = Transaction::orderBy('id', 'DESC')
                ->orderBy('transaction_date', 'DESC')
                ->get();
        }

        if($user->role == "admin" || $user->role == "buyer"){
            return view('transaction.index', compact('result'));
        }else{
            return redirect('/')->with('status','Harap melakukan login terlebih dahulu');
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

        $user = Auth::user();
        if($user->role == "admin"){
            return view('transaction.create', compact('medicine', 'category'));
        }else{
            return redirect()->route('stokAwal.index')->with('status', 'Tidak dapat mengakses halaman Admin');
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

        $dataNota = Transaction::where('name', 'like', 'NT/'. $year . '/' . $month . "/%")
            ->get();

        $totalIndex = str_pad(strval(count($dataNota) + 1), 4, '0', STR_PAD_LEFT);

        //checkstock barang
        $medicineCheckStock = Medicines::where('is_entry', 1)
            ->get();

        $dataReport = DB::table('inventory_transactionline') //dibuat untuk check barang di gudang tersebut apaan yang perlu dibeneri stok nya
            ->select('inventory_transactionline.medicines_id',"inventory_transactionline.jumlah")
            ->get();

        for ($i = 0; $i < count($request->get('medicine')); $i++) {
            $totalCheckStock=0;
            foreach($dataReport as $dr){
                if($dr->medicines_id == $request->get('medicine')[$i]){
                    $totalCheckStock += $dr->jumlah;
                }    
            }
            /*foreach($medicineCheckStock as $m){
                
                if($m->id == $request->get('medicine')[$i]){
                    foreach($m->inventoryTransaction as $c){
                        $totalCheckStock += $c->jumlah;
                    }
                }
            }*/
            if($totalCheckStock < $request->get('quantity')[$i]){
                //return redirect()->route('/katalok')->with('status','Item yang dibeli tidak mencukupi jumlah stok');
                 return redirect('/')->with('status','Item yang dibeli tidak mencukupi jumlah stok');
            }
        }


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
                    'totalprice' => $request->get('quantity')[$i] * $request->get('price')[$i],
                )
            );

            DB::table('medicines')
                ->where('id', $request->get('medicine')[$i])
                ->update(array(
                    'is_buy' => 1,
                )
            );  

            $totalHargaSeluruh = $totalHargaSeluruh + $request->get('quantity')[$i] * $request->get('price')[$i];
        }
        
        /*
        Medecine --> "Medicines::find($request->get('medicine'));"
         dikerem compact($category, $medecine)
         --pilih category--
        category[id] == $medecine->category_id{
            combobox selected
        }else{
            combobox tanpa selected
        }
        */

        /*$obatDipilih = Medicines::find($request->get('medicine'));
        $obatDipilih->is_buy = 1;
        $obatDipilih->save();

        $notaDipilih = Transaction::find($dataNota->id);
        $notaDipilih->total = $totalHargaSeluruh;
        $notaDipilih->save();
        */

        DB::table('transaction')
            ->where('id', $dataNota->id)
            ->update(array(
                'total' => $totalHargaSeluruh,
            )
        );

        $idtransaction = DB::table('inventory_transaction')->insertGetId(
            array(
                'name' => 'NT/'. $year . '/' . $month . "/". $totalIndex,
                'tanggalDibuat' => date("Y-m-d"),
                'transaction_id' => $dataNota->id,
                'created_by' => $user->id,
                'created_on' => date("Y-m-d"),
                'updated_by' => $user->id,
                'updated_on' => date("Y-m-d"),
            )
        );

        for ($i = 0; $i < count($request->get('medicine')); $i++) {
            DB::table('inventory_transactionline')->insert(
                array(
                    'inventory_transaction_id' => $idtransaction,
                    'medicines_id' => $request->get('medicine')[$i],
                    'jumlah' => $request->get('quantity')[$i] * -1,
                )
            );
            //$totalHargaSeluruh = $totalHargaSeluruh + $request->get('quantity')[$i] * $request->get('price')[$i];
        }

        $request->session()->forget('cart');
        //return redirect()->route('/katalok')->with('status', "Berhasil membeli barang");
        return redirect('/')->with('status','Berhasil membeli barang');



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
        $medicine = Medicines::where('is_entry', 1)
            ->get();
        $category = Categories::all();

        $trans = DB::table('transaction')
            ->where('id', $transaction->id)
            ->get();
//dd($trans);
        $medecineTransaction = DB::table('medicine_transaction')
            ->select('medicine_transaction.transaction_id','medicine_transaction.id','medicine_transaction.quantity','medicine_transaction.price','medicine_transaction.totalprice',
            'medicines.generic_name', 'medicines.urlGambar','medicines.form','categories.name')
            ->join('medicines','medicines.id','=','medicine_transaction.medicines_id')
            ->join('categories','medicines.category_id','=','categories.id')
            ->get();
            
        $user = DB::table('users')->get();


        $useras = Auth::user();
        if($useras->role == "admin" || $useras->role == "buyer"){
            return view('transaction.detail', compact('medicine', 'category', 'transaction','user','medecineTransaction', 'trans'));

        }else{
            return redirect('/')->with('status','Harap melakukan login terlebih dahulu');
        }
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


    public function userTerbanyakBeli()
    {
        //
        $result = DB::table('transaction')
            ->select('transaction.user_id as userId', DB::raw('SUM(medicine_transaction.totalprice) as price'))
            ->join('medicine_transaction','transaction.id','=','medicine_transaction.transaction_id')
            ->groupBy('transaction.user_id')
            ->orderBy(DB::raw('SUM(medicine_transaction.totalprice)'), 'DESC')
            ->limit(3)
            ->get();
        $user = DB::table('users')->get();

        $useras = Auth::user();
        if($useras->role == "admin"){
            return view('report.userTerbanyakBeli', [
                'result' => $result,
                'user' => $user,
            ]);
        }else{
            return redirect('/')->with('status','Tidak dapat mengakses halaman Admin');
        }

        
    }
}
