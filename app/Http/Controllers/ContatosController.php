<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Contatos;
use App\Models\Enderecos;

class ContatosController extends Controller
{
    public function index()
    {
        $contatos = Contatos::all();
        return view('contatos',[
            'contatos' => $contatos
        ]);
    }
    public function favoritos()
    {
        $contatos = Contatos::where('favorito', 1)->get();
        return view('favoritos',[
            'contatos' => $contatos
        ]);
    }
    public function novo()
    {
        return view('novo');
    }
    public function detalhe(Request $request, $id)
    {
        $contato = Contatos::find($id);
        return view('detalhe',[
            'contato' => $contato
        ]);
    }
    public function editar()
    {
        return view('editar');
    }

    private function validateFieldsContato(Request $request, $checkImage = false)
    {

        $rules = [
            'nome' => 'required',
            "email" => "required|email",
            'telefone' => 'required'
        ];

        if($checkImage){
            $rules['imagem'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        }
        
        $mensages = [
            'nome.required' => 'Nome deve ser preenchido',
            'email.required' => 'E-mail deve ser preenchido',
            'email.email' => 'E-mail é invalido',
            'telefone.required' => 'Telefone deve ser preenchido'
        ];

        if($checkImage){
            $mensages['imagem.mimes'] = 'Você deve selecionar uma imagem no formato JPEG, JPG, PNG ou GIF';
            $mensages['imagem.max'] = 'A imagem deve ter no máximo 10Mb';
        }
        
        return $request->validate($rules, $mensages);
    
    }

    private function validateFieldsInsert(Request $request, $checkImage = false)
    {

        $rules = [
            'nome' => 'required',
            "email" => "required|email",
            'telefone' => 'required',
            'cep' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required'
        ];

        if($checkImage){
            $rules['imagem'] = 'mimes:jpeg,jpg,png,gif|max:10000';
        }
        
        $mensages = [
            'nome.required' => 'Nome deve ser preenchido',
            'email.required' => 'E-mail deve ser preenchido',
            'email.email' => 'E-mail é invalido',
            'telefone.required' => 'Telefone deve ser preenchido',
            'cep.required' => 'Cep deve ser preenchido',
            'rua.required' => 'Rua deve ser preenchido',
            'numero.required' => 'Número deve ser preenchido',
            'bairro.required' => 'Bairro deve ser preenchido',
            'cidade.required' => 'Cidade deve ser preenchido',
            'estado.required' => 'Estado deve ser preenchido'
        ];

        if($checkImage){
            $mensages['imagem.mimes'] = 'Você deve selecionar uma imagem no formato JPEG, JPG, PNG ou GIF';
            $mensages['imagem.max'] = 'A imagem deve ter no máximo 10Mb';
        }
        
        return $request->validate($rules, $mensages);
    
    }

    private function validateFieldsEndereco(Request $request)
    {

        $rules = [
            'cep' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required'
        ];

        $mensages = [
            'cep.required' => 'Cep deve ser preenchido',
            'rua.required' => 'Rua deve ser preenchido',
            'numero.required' => 'Número deve ser preenchido',
            'bairro.required' => 'Bairro deve ser preenchido',
            'cidade.required' => 'Cidade deve ser preenchido',
            'estado.required' => 'Estado deve ser preenchido'
        ];
        
        return $request->validate($rules, $mensages);
    
    }

    public function ajax(Request $request)
    {
        $arr = array('msg' => 'Ação não permitida!', 'status' => false);

        if($request->input('type_action') == 'cadastro')
        {
            $checkImage = false;
            $imagem = $request['imagem'];
            if($request->hasFile('imagem')){
                $checkImage = true;
                $img = file_get_contents($request->file('imagem'));
                $base64 = 'data:image/' . $request->file('imagem')->getClientOriginalExtension() . ';base64,' . base64_encode($img);
                $imagem = $base64;
            }

            $this->validateFieldsInsert($request,$checkImage);

    
            $contato = [
                'imagem' => $imagem,
                'nome' => $request['nome'],
                'email' => $request['email'],
                'telefone' => $request['telefone'],
                'celular' => $request['celular']
            ];

            $endereco = $request->only('cep', 'rua', 'numero', 'bairro', 'cidade','estado');

            $check = false;
            try {
                DB::beginTransaction();
                $contato_id = Contatos::insertGetId($contato);

                $endereco['contato_id'] = $contato_id;
                Enderecos::insertGetId($endereco);

                DB::commit();
                $check = true;
            } catch (\Exception $e) {

                DB::rollback();
            }
            
            if($check){ 
                $arr = array('msg' => 'Cadastrado realizado com sucesso!', 'status' => true, 'redirect' => '/contatos');
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao realizar o cadastrar!', 'status' => false);
            }

        }

        if($request->input('type_action') == 'atualizar')
        {

            $checkImage = false;
            
            $contato = [
                'nome' => $request['nome'],
                'email' => $request['email'],
                'telefone' => $request['telefone'],
                'celular' => $request['celular']
            ];

            if($request->hasFile('imagem')){
                $checkImage = true;
                $img = file_get_contents($request->file('imagem'));
                $base64 = 'data:image/' . $request->file('imagem')->getClientOriginalExtension() . ';base64,' . base64_encode($img);
                $contato['imagem'] = $base64;
            }

            $this->validateFieldsContato($request,$checkImage);

    
            $check = Contatos::where('id', $request->input('id'))->update($contato);

            if($check){ 
                $arr = array('msg' => 'Cadastro atualizado com sucesso!', 'status' => true, 'reload' => true);
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao atualizar o cadastro!', 'status' => false);
            }

        }

        if($request->input('type_action') == 'adicionar_favoritos' || $request->input('type_action') == 'remover_favoritos')
        {
            $check = Contatos::where('id', $request->input('id'))->update([
                'favorito' => (($request->input('type_action') == 'adicionar_favoritos') ? 1 : 0)
            ]);

            if($check){ 
                $arr = array('status' => true, 'reload' => true);
            }else{
                $arr = array('msg' => 'Ops, não foi possível realizar a ação!', 'status' => false);
            }

        }

        if($request->input('type_action') == 'remover')
        {
            $check = false;
            try{
                DB::beginTransaction();
                Enderecos::where('contato_id', $request->input('id'))->delete();
                Contatos::where('id', $request->input('id'))->delete();
                DB::commit();
                $check = true;
            } catch (\Exception $e) {

                DB::rollback();
            }

            if($check){ 
                $arr = array('msg' => 'Cadastro removido com sucesso!', 'status' => true, 'reload' => true);
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao remover o cadastro!', 'status' => false);
            }
        }

        if($request->input('type_action') == 'cadastro_endereco')
        {
            $this->validateFieldsEndereco($request);

            $endereco = $request->only('cep', 'rua', 'numero', 'bairro', 'cidade','estado','contato_id');

            $check = Enderecos::insert($endereco);
            
            if($check){ 
                $arr = array('msg' => 'Cadastrado realizado com sucesso!', 'status' => true, 'reload' => true);
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao realizar o cadastrar!', 'status' => false);
            }

        }

        if($request->input('type_action') == 'remover_endereco')
        {
            $check = Enderecos::where('id', $request->input('id'))->delete();

            if($check){ 
                $arr = array('status' => true, 'reload' => true);
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao remover o cadastro!', 'status' => false);
            }
        }

        if($request->input('type_action') == 'atualizar_endereco')
        {
            $this->validateFieldsEndereco($request);

            $endereco = $request->only('cep', 'rua', 'numero', 'bairro', 'cidade','estado');

            $check = Enderecos::where('id', $request->input('id'))->update($endereco);

            if($check){ 
                $arr = array('msg' => 'Cadastro atualizado com sucesso!', 'status' => true, 'reload' => true);
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao atualizar o cadastro!', 'status' => false);
            }

        }

        if($request->input('type_action') == 'carregar_contato')
        {
            $contato = Contatos::find($request->input('id'));

            if($contato){ 
                $arr = array('data' => $contato, 'status' => true);
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao carregar os dados!', 'status' => false);
            }
        }

        if($request->input('type_action') == 'carregar_endereco')
        {
            $endereco = Enderecos::find($request->input('id'));

            if($endereco){ 
                $arr = array('data' => $endereco, 'status' => true);
            }else{
                $arr = array('msg' => 'Ops, ocorreu um erro ao carregar os dados!', 'status' => false);
            }
        }

        return Response()->json($arr);

    }

}
