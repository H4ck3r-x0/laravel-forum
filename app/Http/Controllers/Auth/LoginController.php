<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/threads';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        if ($request->wantsJson()) 
        {    
            $validator = $this->validateLogin($request->all());
            if($validator->fails()) {
                return response()->json(['errors' => $validator->getMessageBag()->toArray()], 422);
            } 

             if ($this->authenticate($request)) {
                return response()->json(['errors' => null], 200);
             } else {
                return response()->json(['errors' =>  'These credentials do not match our records.'], 406);
             }
        }

    }


     /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    protected function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($user = Auth::attempt($credentials, $request->has('remember'))) {
            return $user;
        }

    }


    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(array $data)
    {
        return Validator::make($data, [
            $this->username() => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    }
}
