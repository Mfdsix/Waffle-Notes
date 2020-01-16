<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $username;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function sign_in(Request $request){
        $username = request()->input('username');
        $this->username = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $request->merge([$this->username => $username]);

        $validate = Validator::make($request->all(), [
            $this->username => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 422,
                'message' => 'There is field that not valid',
                'data' => null
            ]);
        }

        if(Auth::attempt($request->except('username'))){
            $user = Auth::user();
            return response()->json([
                'status' => 200,
                'message' => 'Login Success',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Wrong Username or Password',
                'data' => null
            ]);
        }
    }

    public function username(){
        return $this->username;
    }
}
