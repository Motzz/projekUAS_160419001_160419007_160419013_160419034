<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('users')
            ->get();
        return view('user.index', [
            'data' => $data,
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
        return view('user.create');
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

        $idUsers = DB::table('users')
            ->insertGetId(
                array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'role' => $request->get('role'),
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s"),
                )
        );
        return redirect()->route('user.index')->with('status','Success!!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return view('user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        return view('user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $users = Auth::user();

        if ($request->get('password') == "" || $request->get('password') == null) {
            DB::table('users')
            ->where('id', $user['id'])
            ->update(array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'role' => $request->get('role'),
                'updated_at' => date("Y-m-d h:i:s"),
            )
        );
        } else {
            DB::table('users')
            ->where('id', $user['id'])//woii su ngapain coggg woii  delok o dc cogg, ngebug kartu stok asuuu
            ->update(array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => $request->get('role'),
                'updated_at' => date("Y-m-d h:i:s"),
            )
        );
        }


        return redirect()->route('users.index')->with('status','Success!!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return redirect()->route('users.index')->with('status','Success!!');
        
    }
}
