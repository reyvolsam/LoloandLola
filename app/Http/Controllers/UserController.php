<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Validator;
use App\User;

class UserController extends Controller
{

    private $res = array();
    private $request;
    private static $generic_password = "Dpilady2019";

    function __construct(Request $request)
    {
        $this->request = $request;
        $this->res['msg'] = '';
        $this->res['status'] = false;

        date_default_timezone_set('America/Mexico_City');
    }//__construct()

    public function index()
    {
        return view('user.index', ['request' => $this->request]);
    }

    public function ListInterface()
    {
        try{
            $users = array();

            $users = User::with('group');

            if(\Auth::getUser()->group_id != 1){
                $users = $users->where('group_id', '!=', 1);
            }

            if(\Auth::getUser()->group_id == 3){
                $users = $users->where('group_id', '=', 4);
            }

            $users = $users->orderBy('id', 'DESC')->get();

            if( count($users) > 0 ){
                foreach ($users as $ku => $vu) {
                    $vu->login = false;
                    if(Auth::user()->id == $vu->id) $vu->login = true;

                    if(\Auth::getUser()->group_id == 6){
                        if($vu->group_id == 8) $vu->login = true;
                    }

                }
                $this->res['data'] = $users;
                $this->res['status'] = true;
            } else {
                $this->res['total'] = 0;
                $this->res['msg'] = 'No hay clientes regitrados hasta el momento.';
            }
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en la Base de Datos.'.$e;
        }
        return response()->json($this->res);
    }//lists

    public function lists()
    {
        try{
            $this->ListInterface();
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//lists()

    public function store()
    {
        try{
            $messages = [
                'first_name.required'       => 'El nombre es requerido.',
                'first_name.max'            => 'El limite del nombre es de 255 caracteres como máximo.',
                'last_name.required'        => 'El apellido es requerido.',
                'last_name.max'             => 'El limite del apellido es de 255 caracteres como máximo.',
                'email.required'            => 'El correo electronico es requerido.',
                'email.max'                 => 'El limite del correo electronico es de 255 caracteres como máximo.',
                'email.email'               => 'Introduzca un correo electornico valido.',
                'group_id.required'         => 'El perfil es requerido.',
            ];

            $validator = Validator::make($this->request->all(), [
                        'first_name'        => 'required|max:255',
                        'last_name'         => 'required|max:255',
                        'email'             => 'required|max:255|email',
                        'group_id'          => 'required'
                    ], $messages);

            $id                     = $this->request->input('id');
            $data['first_name']     = $this->request->input('first_name');
            $data['last_name']      = $this->request->input('last_name');
            $data['email']          = $this->request->input('email');
            $data['group_id']       = $this->request->input('group_id');
            $data['active']         = $this->request->input('active');


            if (!$validator->fails()) {
                if($id == null){

                    $user = User::where('email', '=', $data['email'])->get();

                    if( count($user) == 0 ){
                        $user = User::withTrashed()
                                        ->where('email', '=',$data['email'])
                                        ->get();
                        if( count($user) > 0 ){
                            $user = User::withTrashed()
                                        ->where('email', '=', $data['email'])
                                        ->restore();

                            $user = User::where('email', '=', $data['email'])->first();

                            $user->password         = Hash::make(self::$generic_password);
                            
                            $user->avatar           = 'avatar.png';
                            $user->group_id         = $data['group_id'];
                            $user->active            = $data['active'];
                            $user->save();

                            $this->res['msg'] = 'Usuario restaurado correctamente.';
                            $this->res['status'] = true;
                        } else {
                            $user = new User;
                            $user->first_name       = $data['first_name'];
                            $user->last_name        = $data['last_name'];
                            $user->email            = $data['email'];
                            $user->password         = Hash::make(self::$generic_password);    
                            $user->avatar           = 'avatar.png';
                            $user->group_id         = $data['group_id'];
                            $user->active           = $data['active'];
                            $user->save();

                            $this->res['msg'] = 'Usuario creado correctamente.';
                            $this->res['status'] = true;
                        }
                    } else {
                        $this->res['msg'] = 'El usuario ya existe.';
                    }
                } else {
                    $user = User::find($id);

                    $user->first_name       = $data['first_name'];
                    $user->last_name        = $data['last_name'];
                    $user->email            = $data['email'];
                    $user->active           = $data['active'];
                    $user->group_id         = $data['group_id'];                    
                    $user->save();

                    $this->res['msg'] = 'Usuario actualizado correctamente.';
                    $this->res['status'] = true;                    
                }
            } else {
                $this->res['msg'] = 'Por favor llene todos los campos requeridos.';
            }
        } catch(\Exception $e) {
            $this->res['msg'] = 'Error en la Base de Datos.'.$e;
        }
        return response()->json($this->res);
    }//spore

    public function ResetPassword()
    {
        try{
            $user_id = $this->request->input('user_id');
            $new_password = $this->request->input('new_password');
            $new_password_confirm = $this->request->input('new_password_confirm');

            $validator = Validator::make([  
                                'new_password'          => $new_password, 
                                'new_password_confirm'  => $new_password_confirm
                        ], [
                        'new_password'                  => 'required',
                        'new_password_confirm'          => 'required'
                    ]);

            if (!$validator->fails()) {
                if($new_password == $new_password_confirm){
                    $user = User::find($user_id);

                    $user->password         = Hash::make($new_password);
                    $user->save();

                    $this->res['msg'] = 'Contraseña modificada correctamente.';
                    $this->res['status'] = true;
                } else {
                    $this->res['msg'] = 'Las contraseñas deben de coincidir.';
                }
            } else {
                $this->res['msg'] = 'Todos los campos son requeridos.';
            }
        }catch(\Exception $e){  
            $this->res['msg'] = 'Error en el sistema.'.$e;
        }
        return response()->json($this->res);
    }//ResetPassword()

    public function destroy($id)
    {
        try{
            $user = User::find($id);
            $user->group_id = null;
            $user->save();

            $user->delete();

            $this->res['msg'] = 'Usuario eliminado correctamente.';
            $this->res['status'] = true;
        } catch (\Exception $e) {
            $this->res['msg'] = 'Error en la Base de Datos'.$e;
        }
        return response()->json($this->res);
    }//destroy

    public function actdes()
    {
        try{
            $id         = $this->request->input('id');
            $active     = $this->request->input('active');

            $msg = '';
            $user = User::find($id);

            $user->active = !$active;
            ($active == 1) ? $msg = 'Usuario desactivado correctamente.' : $msg = 'Usuario activado correctamente.';
            $user->save();

            $this->res['msg'] = $msg;
            $this->res['status'] = true;

        } catch(\Exception $e){
            $this->res['msg'] = 'Error del sistema.'.$e;
        }
        return response()->json($this->res);
    }//actdes()

}//UserController
