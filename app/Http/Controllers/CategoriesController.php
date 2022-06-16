<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result = Categories::all();
        return view('categories.index', compact('result'));
    }

    public function showList($id_category)
    {
        $data = Category::find($id_category);
        $namecategory = $data->name;
        $result = $data->medicines;
        if ($result) $getTotalData = $result->count();
        else $getTotalData = 0;
        return view(
            'report.list_medicines_by_category',
            compact('id_category', 'namecategory', 'result', 'getTotalData')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('categories.create');
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
        
        DB::table('categories')
            ->insert(array(
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'created_by'=> $user->id,
                'created_on'=> date("Y-m-d h:i:s"),
                'updated_by'=> $user->id,
                'updated_on'=> date("Y-m-d h:i:s"),
            )
        ); 
        return redirect()->route('categories.index')->with('status','Success!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $category)
    {
        //
        $data = Category::find($category);
        $namecategory = $data->name;
        $result = $data->medicines;
        if ($result) $getTotalData = $result->count();
        else $getTotalData = 0;
        return view(
            'report.list_medicines_by_category',
            compact('id_category', 'namecategory', 'result', 'getTotalData')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $category)
    {
        //
        return view('categories.edit', [
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $category)
    {
        //
        $user = Auth::user();
        DB::table('categories')
            ->where('id', $category['id'])
            ->update(array(
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'updated_by'=> $user->id,
                'updated_on'=> date("Y-m-d h:i:sa"),
            )
        );
        return redirect()->route('categories.index')->with('status','Success!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $category)
    {
        //

        $category->delete();
        return redirect()->route('categories.index')->with('status','Delete Success!!');  
    }
}
