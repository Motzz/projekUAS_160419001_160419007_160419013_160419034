<?php

namespace App\Http\Controllers;

use App\Medicines;
use Illuminate\Http\Request;

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
        $data=$medicine;
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
