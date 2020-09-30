@extends('template')

@section('main')
<br/>
<h2>Cadastro</h2>
<br/>
<div class="row">
      <div class="col-sm-4">
        <form method="post" action="/login/send">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" />
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" class="form-control" id="email" name="email" />
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" class="form-control" id="password" name="password" />
            </div>
            <input type="hidden" id="type_action" name="type_action" value="registrar" />
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a href="/login" class="btn btn-success">Login</a>
        </form>
    </div>
</div>
@endsection