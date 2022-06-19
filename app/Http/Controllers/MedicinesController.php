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

        $file = $request->file('gambarObat');
        $imgFolder = 'img';
        $imgFile = time()."_".$file->getClientOriginalName();
        $file->move($imgFolder, $imgFile);
        $data->urlGambar=$imgFile;
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
    public function edit(Medicines $medicines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medicines  $medicines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medicines $medicines)
    {
        //
        $file = $request->file('gambarObat');
        $imgFolder = 'img';
        $imgFile = time()."_".$file->getClientOriginalName();
        $file->move($imgFolder, $imgFile);
        $data->urlGambar=$imgFile;

        $user = Auth::user();
        DB::table('medicines')
            ->where('id', $medicines['id'])
            ->update(array(
                'generic_name' => $request->get('generic_name'),
                'price' => $request->get('price'),
                'form' => $request->get('form'),
                'restriction formula' => $request->get('restriction_formula'),
                'description' => $request->get('description'),
                'faskes1' => $request->get('faskes1'),
                'faskes2' => $request->get('faskes2'),
                'faskes3' => $request->get('faskes3'),
                'category_id' => $request->get('kategori'),
                'updated_by'=> $user->id,
                'updated_on'=> date('Y-m-d H:i:s'),
                'urlGambar'=>$imgFile
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
        $category->delete();
        return redirect()->route('medicines.index')->with('status','Delete Success!!');  
    }
}
