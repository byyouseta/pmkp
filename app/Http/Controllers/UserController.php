<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use DB;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
    }

    public function index()
    {
        session()->put('ibu', 'Master');
        session()->put('anak', 'Master Users');

        $data = User::all();
        $data2 = Unit::all();
        $data3 = Role::all();

        return view('masters.users', compact('data', 'data2', 'data3'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'unit' => 'required',
            'nohp' => 'numeric|digits_between:10,13',
            'akses' => 'required',
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
        $user->assignRole($request->input('akses'));

        Session::flash('sukses', 'Data Berhasil ditambahkan!');

        return redirect('/user');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data = User::find($id);
        $data2 = Unit::all();
        $data3 = Role::all();

        return view('masters.users_edit', [
            'data' => $data,
            'data2' => $data2,
            'data3' => $data3
        ]);
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

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('akses'));

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/user');
    }

    public function profile()
    {
        session()->put('ibu', 'Profile');
        // session()->put('anak', 'Master Users');

        $data = User::find(Auth::user()->id);
        // $data2 = Unit::all();

        return view('profil', compact('data'));
    }

    public function profileupdate(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . Auth::user()->id,
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            // 'akses' => 'required',
            // 'unit' => 'required',
            'nohp' => 'numeric|digits_between:10,13|unique:users,nohp,' . Auth::user()->id,
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->nohp = $request->nohp;
        // $user->unit_id = $request->unit;
        // $user->akses = $request->akses;
        $user->save();

        Session::flash('sukses', 'Data Berhasil diperbaharui!');

        return redirect('/profile');
    }

    public function password(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        /*
        * Validate all input fields
        */
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6|different:old_password',
        ], [
            'password.confirmed' => 'Password Baru dan Konfirmasi Password tidak sama!',
            'password.min' => 'Password Baru minimal 6 karakter!',
            'password.different' => 'Password Baru harus berbeda dengan Password Lama',
        ]);

        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            Session::flash('sukses', 'Password berhasil diperbaharui');
            // $request->session()->flash('sukses', 'Password berhasil diubah');
            return redirect('/profile');
        } else {

            Session::flash('error', 'Password lama tidak sama dengan didata');
            // $request->session()->flash('error', 'Password lama tidak sama dengan didata');
            return redirect('/profile');
        }
    }
}
