<?php

namespace App\Http\Controllers;

use App\Exports\CategoriesExport;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Mongodb\Auth\Authenticatable;
use Maatwebsite\Excel\Facades\Excel;
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

    public function exportExcel()
    {
        return Excel::download(new CategoriesExport, 'category.xlsx');
    }
}
