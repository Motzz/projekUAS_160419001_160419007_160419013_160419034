<?php

namespace App\Http\Controllers;

use App\Medicines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Categories;
class MedicinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result = Medicines::all();
        $kategori=Categories::all();

        //compact
        //return view('medicine.index', compact('result'));

        //parameter
        $user = Auth::user();
        if($user->role == "admin"){
            return view('medicine.index', [
                'result' => $result,
                'kategori'=>$kategori
            ]);
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
        
        $kategori=Categories::all();
        $user = Auth::user();
        if($user->role == "admin"){
            return view('medicine.create', [
                'kategori' => $kategori
            ]);
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
        $data=new Medicines();
        $data->generic_name=$request->get('name');
        $data->price=$request->get('price');
        $data->form=$request->get('form');
        $data->restriction_formula=$request->get('restriction_formula');
        $data->description=$request->get('description');
        $data->faskes1=$request->get('faskes1');
        $data->faskes2=$request->get('faskes2');
        $data->faskes3=$request->get('faskes3');
        $data->category_id=$request->get('kategori');
        $data->created_by=$user->id;
        $data->created_on=date("Y-m-d h:i:sa");
        $data->updated_by=$user->id;
        $data->updated_on=date("Y-m-d h:i:sa");

       /* $file = $request->file('logo');
        $imgFolder = 'img';
        $imgFile = time()."_".$file->getClientOriginalName();
        $file->move($imgFolder, $imgFile);
        $data->logo=$imgFile;*/

        $validatedData = $request->validate([
            'gambarObat' => 'required|image|mimes:jpg,png,jpeg,svg|max:6048',
        ]);
        $path = "";
        if ($request->hasFile('gambarObat')) {
            $image = $request->file('gambarObat');
            $image_name = $image->getClientOriginalName();
            $image->move(public_path('img'), $image_name);

            $path = $image_name;
            $data->urlGambar=$path;
        }
       
        $data->save();

        return redirect()->route('medicines.index')->with('status','Success!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medicines  $medicines
     * @return \Illuminate\Http\Response
     */
    public function show(Medicines $medicines)
    {
        $data=$medicines;

        $user = Auth::user();
        if($user->role == "admin"){
            return view('medicine.show',compact('data'));
        }else{
            return redirect('/')->with('status','Tidak dapat mengakses halaman Admin');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medicines  $medicines
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicines $medicine)
    {
        //
        $kategori=Categories::all();
       // dd($medicine);

        $user = Auth::user();
        if($user->role == "admin"){
            return view('medicine.edit', [
                'medicines'=>$medicine,
                'kategori' => $kategori
            ]);
        }else{
            return redirect('/')->with('status','Tidak dapat mengakses halaman Admin');
        }
          
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medicines  $medicines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medicines $medicine)
    {
        //
        $validatedData = $request->validate([
            'gambarObat' => 'image|mimes:jpg,png,jpeg,svg|max:6048',
        ]);
        $path = $medicine->urlGambar;
        if ($request->hasFile('gambarObat')) {
            $image = $request->file('gambarObat');
            $image_name = time()."_".$image->getClientOriginalName();
            $image->move(public_path('img'), $image_name);

            $path = $image_name;
        }


        $user = Auth::user();
        DB::table('medicines')
            ->where('id', $medicine['id'])
            ->update(array(
                'generic_name' => $request->get('generic_name'),
                'price' => $request->get('price'),
                'form' => $request->get('form'),
                'restriction_formula' => $request->get('restriction_formula'),
                'description' => $request->get('description'),
                'faskes1' => $request->get('faskes1'),
                'faskes2' => $request->get('faskes2'),
                'faskes3' => $request->get('faskes3'),
                'category_id' => $request->get('kategori'),
                'updated_by'=> $user->id,
                'updated_on'=> date('Y-m-d H:i:s'),
                'urlGambar'=>$path
            )
        );
        return redirect()->route('medicines.index')->with('status','Success update medicine data!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medicines  $medicines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicines $medicine)
    {
        //
        
        if($medicine->is_buy == 0){
             //DB::table('medicines')->where('ItemTypeID', $itemType['ItemTypeID'])->delete();
            //$medicines->delete();
            DB::table('medicines')->where('id', $medicine->id)->delete();
            return redirect()->route('medicines.index')->with('status','Delete Success!!');  
        }
        else{
            return redirect()->route('medicines.index')->with('status','Delete Failed!!');  
        }
    }

    public function front_index()
    {
        $medicines = Medicines::all();
        $user = Auth::user();
        $kategor=Categories::all();

        $dataReport = DB::table('inventory_transactionline') //dibuat untuk check barang di gudang tersebut apaan yang perlu dibeneri stok nya
            ->select('inventory_transactionline.medicines_id',"inventory_transactionline.jumlah")
            ->get();

        if(Auth::check()){
            if($user->role == "buyer"){
                return view('frontend.product', compact('medicines', 'dataReport','kategor'));
            }else{
                return redirect()->route('medicines.index')->with('status','Tidak dapat mengakses halaman Buyer');
            }
        }
        else{
            return view('frontend.product', compact('medicines','dataReport','kategor'));
        }
        
    }

    public function addToCart($id)
    {
        $p = Medicines::find($id);
        $cart = session()->get('cart');
        if (!isset($cart[$id])) {
            $cart[$id] = [
                "name" => $p->generic_name . "(" . $p->form . ")",
                "quantity" => 1,
                "price" => $p->price,
                "photo" => $p->urlGambar,
                "idMedicine" => $p->id,
                "hapus" => 0,
            ];
        } else {
            $cart[$id]['quantity']++;
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product ' . $cart[$id]['name'] . " jumlah " . $cart[$id]['quantity']);
    }
    public function minToCart($id)
    {
        $p = Medicines::find($id);
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            if($cart[$id]['quantity'] == 1){
                $cart[$id]['quantity']--;
                $cart[$id]['hapus'] = 1;
            }
            else{
                $cart[$id]['quantity']--;
                $cart[$id]['hapus'] = 0;
            }
        } 
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product ' . $cart[$id]['name'] . " jumlah " . $cart[$id]['quantity']);
    }

    public function checkout()
    {
        $user = Auth::user();
        if($user->role == "buyer"){
            return view('frontend.checkout'); 
        }else{
            return redirect()->route('medicines.index')->with('status','Tidak dapat mengakses halaman Buyer');
        }
    }

    public function medicinesTerlaris()
    {
        //
        $result = DB::table('medicines')
            ->select('medicines.id', 'medicines.generic_name', 'medicines.price', 'medicines.form', 'medicines.restriction_formula', 
            'medicines.description', 'medicines.faskes1', 'medicines.faskes2', 'medicines.faskes3', 'medicines.urlGambar', 
            'medicines.category_id', DB::raw('SUM(inventory_transactionline.jumlah) as Quantity'))
            ->join('inventory_transactionline','medicines.id','=','inventory_transactionline.medicines_id')
            ->join('inventory_transaction','inventory_transactionline.inventory_transaction_id','=','inventory_transaction.id')
            ->whereNotNull('inventory_transaction.transaction_id')
            ->groupBy('medicines.id', 'medicines.generic_name', 'medicines.price', 'medicines.form', 'medicines.restriction_formula', 'medicines.description', 
            'medicines.faskes1', 'medicines.faskes2', 'medicines.faskes3', 'medicines.urlGambar', 'medicines.category_id')
            ->orderByRaw('SUM(inventory_transactionline.jumlah) ASC')
            ->limit(5)
            ->get();
        //dd($result);
        $category = DB::table('categories')->get();

        $user = Auth::user();
        if($user->role == "admin"){
            return view('report.medicinesTerlaris', [
                'result' => $result,
                'category' => $category,
            ]);
        }else{
            return redirect('/')->with('status','Tidak dapat mengakses halaman Admin');
        }
    }
}
