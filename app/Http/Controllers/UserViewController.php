<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mongodb\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Session;

class UserViewController extends Controller
{
    public function postlogin(Request $request)
    {
        $response = Http::post('http://103.162.31.19:1818/api/emr/login',
        [
            'email' => $request->email,
            'password' => $request->password,

        ]);

        $token = $this->index($response->body());

        return redirect()->to("/user");
    }

    public function index($data)
    {
        $token = json_decode($data)->token;
//        dd($token);
        $response = Http::accept('application/json')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get('http://103.162.31.19:1818/api/emr/user');

        dd($response->body());
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
