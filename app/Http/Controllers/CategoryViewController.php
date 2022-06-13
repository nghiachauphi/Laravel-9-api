<?php

namespace App\Http\Controllers;

use App\Exports\CategoriesExport;
use App\Imports\CategoriesImport;
use Illuminate\Mongodb\Auth\Authenticatable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
//use Session;

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

    public function importExcel()
    {
        Excel::import(new CategoriesImport, 'file_import.xlsx');

        return redirect('/category')->with('success', 'All good!');
    }
}
