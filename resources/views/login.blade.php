@extends('template')

@section('main')
<br/>
<h2>Login</h2>
<br/>
<div class="row">
      <div class="col-sm-4">
        <form method="post" action="/login/send">
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" class="form-control" id="email" name="email" />
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" class="form-control" id="password" name="password" />
            </div>
            <input type="hidden" id="type_action" name="type_action" value="login" />
            <button type="submit" class="btn btn-primary">Entrar</button>
            <a href="/cadastro" class="btn btn-success">Cadastro</a>
        </form>
    </div>
</div>
@endsection