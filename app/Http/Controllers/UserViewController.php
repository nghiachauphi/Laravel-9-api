<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Mongodb\Auth\Authenticatable;
use Illuminate\Support\Facades\Session;
//use Session;

class UserViewController extends Controller
{
    public function postlogin(Request $request)
    {
        $response = Http::post('http://103.162.31.19:1818/api/emr/login',
        [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->to("/user");
    }

    public function index()
    {
        $response = Http::accept('application/json')->withHeaders([
            'Authorization' => 'Bearer '.session('token')
        ])->get('http://103.162.31.19:1818/api/emr/user');

        $data = json_decode($response->body());

        return view('user.index')->with('data',$data);
    }

    public function login_local()
    {
        return view('/user');
    }

    public function index_local()
    {
        return view('user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function update()
    {
        return view('user.index');
    }

    public function delete()
    {
        return view('user.delete');
    }
}
