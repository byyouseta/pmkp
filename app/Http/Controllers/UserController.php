<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Users');

        $data = User::all();
        $data2 = Unit::all();

        return view('users', compact('data', 'data2'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'akses' => 'required',
            'unit' => 'required',
            'nohp' => 'numeric|digits_between:10,13'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->nohp = $request->nohp;
        $user->unit_id = $request->unit;
        $user->akses = $request->akses;
        $user->password = Hash::make($request->username);
        $user->save();

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/user');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = User::find($id);
        $data2 = Unit::all();
        return view('users_edit', ['data' => $data, 'data2' => $data2]);
    }

    public function update($id, Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'akses' => 'required',
            'unit' => 'required',
            'nohp' => 'numeric|digits_between:10,13|unique:users,nohp,' . $id,
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->nohp = $request->nohp;
        $user->unit_id = $request->unit;
        $user->akses = $request->akses;
        $user->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/user');
    }
}
