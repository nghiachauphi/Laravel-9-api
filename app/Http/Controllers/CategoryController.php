<?php

namespace App\Http\Controllers;

use App\Imports\CategoriesImport;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mongodb\Auth\Authenticatable;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['login', 'register']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = $request->page_number;
        $max_item = 5;
        $category = Category::all();
        $length = count($category);

        if ($paginate == null)
        {
            $category_latest = Category::latest()->take($max_item)->get();
            return response()->json(["data" => $category_latest,"length" => $length], 200);
        }
        else{
            $skipp_item = ($paginate-1) * $max_item;
            $category = Category::skip($skipp_item)->take($max_item)->get();

            return response()->json(["data" => $category,"length" => $length], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $valid = Validator::make($request->all(),[
            "name" => "sometimes|required|string|min:3|unique:categories",
        ]);

        if ($valid->fails()){
            return response()->json(["message" => $valid->errors()], 400);
        }
        else {
            $response = Category::create([
                "name" => $request->name,
                "author" => auth::user()->name,
                "discription" => $request->discription
            ]);

            //strtoupper() hàm này dùng để in hoa kí tự
            return response()->json(["message" => "Thêm danh mục ". '<strong>'.$response->name .'</strong>' ." thành công","data" => $response],200);
        }

        return response()->json(["message" => "Thêm danh mục thất bại","data" => $response],400);
    }

    public function delete(Request $request)
    {
        $category = Category::where('_id',$request->_id)->first();

        if ($category == null)
        {
            return response()->json(["message" => "Không tìm thấy danh mục"], 400);
        }

        $category->delete();

        return response()->json(["message" => "Xóa danh mục ".$category->name ." thành công"], 200);
    }

    public function update(Request $request)
    {
        $valid = Validator::make($request->all(),[
            "name" => "required|string|min:3|unique:categories,name,{$request->_id},_id"
        ]);

        if ($valid->fails()){
            return response()->json(["message" => $valid->errors()], 400);
        }
        else {
            $response = Category::where("_id", $request->_id)->update([
                "name" => $request->name,
                "author_update" => auth::user()->name,
                "discription" => $request->discription
            ]);

            return response()->json(["message" => "Cập nhật danh mục ". '<strong>'.$request->name .'</strong>' ." thành công","data" => $request],200);
        }

        return response()->json(["message" => "Cập nhật danh mục thất bại","data" => $request],400);
    }

    public function importExcel(Request $request)
    {
        $session = DB::connection('mongodb')->getMongoClient()->startSession();

        $session->startTransaction();
                dd($session);
        try {
            // Perform actions.
            Excel::import(new CategoriesImport, $request->file('file_import'));
            $session->commitTransaction();
        } catch(Exception $e) {
            $session->abortTransaction();
        }

        return response()->json(["message" => "Nhập thành công"],200);
    }
}
