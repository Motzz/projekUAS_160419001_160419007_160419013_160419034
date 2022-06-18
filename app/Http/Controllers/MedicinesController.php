<?php

namespace App\Http\Controllers;

use App\Medicines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        //compact
        //return view('medicine.index', compact('result'));

        //parameter
        return view('medicine.index', [
            'data' => $result
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
        $user = Auth::user();
        DB::table('medicines')
            ->where('id', $medicines['id'])
            ->update(array(
                'name' => $request->get('generic_name'),
                'price' => $request->get('price'),
                'form' => $request->get('form'),
                'restriction formula' => $request->get('restriction_formula'),
                'description' => $request->get('description'),
                'updated_by'=> $user->id,
                'updated_on'=> date('Y-m-d H:i:s'),
            )
        );
        return redirect()->route('medicines.index')->with('status','Success!!');
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
    }
}
