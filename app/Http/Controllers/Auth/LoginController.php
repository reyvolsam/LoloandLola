<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Validator;
use Auth;

use App\User;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->res['status'] = false;
        $this->res['msg'] = '';
        date_default_timezone_set('America/Mexico_City');
    }//

    public function index()
    {
        if( \Auth::check() ){
           return redirect('/');
        } else {
            return view('login');
        }
    }//index

    public function auth()
    {
        try {
            $messages = [
                'email.required' => 'El Usuario es requerido.',
                'passwd.required' => 'La Contraseña es requerida.'
            ];

            $validator = Validator::make($this->request->all(), [
                        'email'     => 'required|max:255',
                        'passwd'    => 'required',
                    ], $messages);

            $usr = User::where('email', 'LIKE', $this->request->input('email'))->first();

            if($usr){        
                if (!$validator->fails()) {
                    $actusr = User::where('email', 'LIKE', $this->request->input('email'))
                                        ->where('active', '=', 1)
                                        ->first();
                    if($actusr){
                        if(Auth::attempt(['email' => $this->request->input('email'), 'password' =>  $this->request->input('passwd')])) {
                            $this->res['status'] = true;
                        } else {
                            $this->res['msg'] .= 'El correo electronico o la contraseña estan incorrectos.';
                        }
                    } else {
                        $this->res['msg'] = 'El usuario no esta activado.';    
                    }
                } else {
                    $this->res['msg'] = 'El nombre de usuario y contraseña son requeridos.';
                }
            } else {
                $this->res['msg'] = 'El usuario no existe.';
            }
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en la Base de Datos.'.$e;
        }
        return response()->json($this->res);
    }//auth

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }//

}////
