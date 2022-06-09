<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Mongodb\Auth\Authenticatable;
use Session;

class CategoryViewController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['login', 'register']]);
    }
    
    public function index()
    {
        return view('category.index');
    }

    public function create()
    {
        return view('category.create');
    }

    public function update()
    {
        return view('category.index');
    }

    public function delete()
    {
        return view('category.delete');
    }
}
