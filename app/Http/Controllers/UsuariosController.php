<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Redirect;

class UsuariosController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function cadastro()
    {
        return view('cadastro');
    }

    public function logout()
    {
        Auth::guard()->logout();
        return Redirect::to('/login');
    }
    
    private function validateFields(Request $request)
    {

        $rules = [
            "email" => "required|email|unique:tb_users,email",
            'password' => 'required'
        ];
        
        $mensages = [
            'email.required' => 'E-mail deve ser preenchido',
            'email.email' => 'E-mail é invalido',
            'email.unique' => 'E-mail já está cadastrado',
            'password.required' => 'Senha deve ser preenchida'
        ];
        
        return $request->validate($rules, $mensages);
    
    }

    private function validateFieldsRegistro(Request $request)
    {

        $rules = [
            'nome' => 'required',
            "email" => "required|email|unique:tb_usuarios,email",
            'password' => 'required'
        ];
        
        $mensages = [
            'nome.required' => 'Nome deve ser preenchido',
            'email.required' => 'E-mail deve ser preenchido',
            'email.email' => 'E-mail é invalido',
            'email.unique' => 'E-mail já está cadastrado',
            'password.required' => 'Senha deve ser preenchida'
        ];
        
        return $request->validate($rules, $mensages);
    
    }

    public function ajax(Request $request)
    {
        $arr = array('msg' => 'Ação não permitida!', 'status' => false);

        if($request->input('type_action') == 'login')
        {
            $this->validateFields($request);
            
            $auth = Auth::guard()->attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);
            
            if($auth){
                $arr = array('status' => true, 'redirect' => '/contatos');
            }else{
                $arr = array('msg' => 'Não foi possível fazer login, verifique os dados de acesso!', 'status' => false);
            }

        }

        if($request->input('type_action') == 'registrar')
        {
            $this->validateFieldsRegistro($request);
    
            $check = Usuarios::insert([
                'nome' => $request['nome'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            
            if($check){ 
                $arr = array('msg' => 'Cadastrado realizado com sucesso!', 'status' => true, 'redirect' => '/login');
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao realizar o cadastrar!', 'status' => false);
            }

        }

        return Response()->json($arr);

    }

}
