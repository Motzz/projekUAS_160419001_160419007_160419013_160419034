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
        return view('medicine.index', [
            'result' => $result,
            'kategori'=>$kategori
        ]);
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
          return view('medicine.create', [
            'kategori' => $kategori
        ]);

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


        $validatedData = $request->validate([
            'gambarObat' => 'required|image|mimes:jpg,png,jpeg,svg|max:6048',
        ]);
        $path = "";
        if ($request->hasFile('gambarObat')) {
            $image = $request->file('gambarObat');
            $image_name = $image->getClientOriginalName();
            $image->move(public_path('/img'), $image_name);

            $path = '/img/' . $image_name;
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
        return view('medicine.show',compact('data'));
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
          return view('medicine.edit', [
            'medicines'=>$medicine,
            'kategori' => $kategori
        ]);
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
            $image->move(public_path('/img'), $image_name);

            $path = '/img/' . $image_name;
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
    public function destroy(Medicines $medicines)
    {
        //
        if($medicines->is_buy == 0){
            $medicines->delete();
            return redirect()->route('medicine.index')->with('status','Delete Success!!');  
        }
        else{
            return redirect()->route('medicine.index')->with('status','Delete Failed!!');  
        }
    }

    public function front_index()
    {
        $medicines = Medicines::all();
        return view('frontend.product', compact('medicines'));
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
                "photo" => $p->image
            ];
        } else {
            $cart[$id]['quantity']++;
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product ' . $cart[$id]['name'] . " jumlah " . $cart[$id]['quantity']);
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }
}
