@extends('template')

@section('main')
<br/>
<h2>Cadastro de Contato</h2>
<br/>
<form method="post" action="/contatos/send" enctype="multipart/form-data">
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
            <label>Imagem</label>
            <input type="file" class="form-control" id="imagem" name="imagem" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
            <label>Nome*</label>
            <input type="text" class="form-control" id="nome" name="nome" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
            <label>E-mail*</label>
            <input type="text" class="form-control" id="email" name="email" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
            <label>Telefone*</label>
            <input type="text" class="form-control" id="telefone" name="telefone" />
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
            <label>Celular</label>
            <input type="text" class="form-control" id="celular" name="celular" />
        </div>
      </div>
    </div>

    <h3>Endereço</h3>

    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
            <label>CEP*</label>
            <input type="text" class="form-control" id="cep" name="cep" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
            <label>Rua*</label>
            <input type="text" class="form-control" id="rua" name="rua" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
            <label>Número*</label>
            <input type="text" class="form-control" id="numero" name="numero" />
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
            <label>Bairro*</label>
            <input type="text" class="form-control" id="bairro" name="bairro" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-3">
        <div class="form-group">
            <label>Cidade*</label>
            <input type="text" class="form-control" id="cidade" name="cidade" />
        </div>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
            <label>Estado*</label>
            <input type="text" class="form-control" id="estado" name="estado" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6 d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Cadastrar</button>
          <input type="hidden" id="type_action" name="type_action" value="cadastro" />
          <a href="/contatos" class="btn btn-warning">Cancelar</a>
      </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
      $('#telefone').mask('(99) 9999-9999');
      $('#celular').mask('(99) 9999-99999');
      $('#cep').mask('99999-999');
    });
    </script>
</form>
@endsection


