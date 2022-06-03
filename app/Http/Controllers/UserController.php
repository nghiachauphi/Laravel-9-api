<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mongodb\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['login', 'register']]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'avatar_upload' => ['required'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = auth::user();

        $user = User::where("api_token",$userId->api_token)->first();

        return response()->json(["get info user success:" => $user], 200);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            Auth::guard('web')->user()->generateAndSaveApiAuthToken();

            $user = User::where('email', $request['email'] )->first();
            auth()->login($user, true);

            return response()->json(['login success' => $user], 200);

        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->api_token = null;
            $user->save();
            auth()->logout();
        }

        return response()->json(['Success' => 'Logged out', 'data' => $user], 200);
    }

    public function change_password(Request $request)
    {
        $userid = Auth::user();

        $input = $request->all();

        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), $userid->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), $userid->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {

                    User::where('api_token', $userid->api_token)->update([
                        'password' => Hash::make($input['new_password']),
                        'api_token' => null,
                    ]);

                    $out_data = Auth::guard('web')->user()->generateAndSaveApiAuthToken();

                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => $out_data);
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
        }
        return response()->json($arr);
    }

    // Form thêm hình ảnh
    public function getImage($id)
    {
        $userId = auth()->user()->id;
        $user = User::find($id);
        return view('user', compact('user'));
    }

    // Xử lý thêm ảnh
    public function postImage(Request $request, $id)
    {
        $user = User::find($id);
        if($request->hasFile('avatar_upload')){

            $fImage = $request->file('avatar_upload');
            $bientam = time().'_'.$fImage->getClientOriginalName();
            $destinationPath = public_path('/upload');
            $fImage->move($destinationPath,$bientam);
            $user->avatar_upload = $bientam;
        }
        else{
            $user->avatar_upload = $user->old_image;
        }

        $user->save();
        return redirect('/user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 400);
        }
        else {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'email_verified_at' => null,
                'password' => Hash::make($request['password']),
                'remember_token' => null,
            ]);
            return response()->json(['message' => "Đăng ký thành công.", 'data' => $user], 200);
        }
    }
}
