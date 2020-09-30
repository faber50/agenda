@extends('template')

@section('main')
  <br/>
  <h2>Contato {{$contato->nome}}</h2>
  <br/>

  <div class="row">
      <div class="col-sm-2">
        <img src="{{$contato->imagem}}" class="figure-img img-fluid rounded-circle rounded" />
      </div>
      <div class="col-sm">
        <h4>Nome: {{$contato->nome}}</h4>
        <p><strong>E-mail:</strong> {{$contato->email}}</p>
        <p><strong>Telefone:</strong> {{$contato->telefone}}</p>
        <p><strong>Celular:</strong> {{$contato->celular}}</p>
        @auth
        <a href="javascript:void(0);" onclick="Favoritar({{$contato->id}},{{(($contato->favorito) ? 'false' : 'true')}});" class="btn btn-warning"><i class="{{(($contato->favorito) ? 'fas' : 'far')}} fa-heart"></i></a>
        <a href="javascript:void(0);" onclick="Editar({{$contato->id}});" class="btn btn-primary">Editar</a>
        @endauth
      </div>
    </div>

  <br/>
  <h2>Endereços</h2>
  <div class="row justify-content-between">
      @foreach($contato->Enderecos as $endereco)
      <div class="col-sm-4">
        <div class="card" style="width: 100%; margin-bottom:30px;">
          <div class="card-body">
            <h5 class="card-title">{{$endereco->rua}}, {{$endereco->numero}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$endereco->cep}}</h6>
            <p class="card-text">{{$endereco->bairro}}, {{$endereco->cidade}} - {{$endereco->estado}}</p>
            @auth
            <a href="javascript:void(0);" onclick="EditarItem({{$endereco->id}});" class="btn btn-primary">Editar</a>
            <a href="javascript:void(0);" onclick="RemoverItem({{$endereco->id}});" class="btn btn-danger">Remover</a>
            @endauth
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <br/>
  @auth
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEndereco">Adicionar endereço</button>
  @endauth
  
  <div class="modal fade" id="modalEndereco" tabindex="-1" aria-labelledby="modalEnderecoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="post" action="/contatos/send" enctype="multipart/form-data" class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="modalEnderecoLabel">Adicionar endereço</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                  <label>CEP*</label>
                  <input type="text" class="form-control" id="cep" name="cep" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                  <label>Rua*</label>
                  <input type="text" class="form-control" id="rua" name="rua" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Número*</label>
                  <input type="text" class="form-control" id="numero" name="numero" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Bairro*</label>
                  <input type="text" class="form-control" id="bairro" name="bairro" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Cidade*</label>
                  <input type="text" class="form-control" id="cidade" name="cidade" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Estado*</label>
                  <input type="text" class="form-control" id="estado" name="estado" />
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <input type="hidden" id="type_action" name="type_action" value="cadastro_endereco" />
          <input type="hidden" id="contato_id" name="contato_id" value="{{$contato->id}}" />
          <button type="submit" class="btn btn-primary">Adicionar</button>
        </div>

      </form>

    </div>
  </div>

  <script type="text/javascript">
      $(document).ready(function(){
        $('#telefone').mask('(99) 9999-9999');
        $('#celular').mask('(99) 9999-99999');
        $('#cep').mask('99999-999');
      });
      function Favoritar(id,remover) {
        RequestPost({
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          fields : {
            id: id,
            type_action: ((remover) ? 'adicionar_favoritos' : 'remover_favoritos'),
          },
          url : '/contatos/send'
        });
      }

      function RemoverItem(id) {
        if(confirm('Deseja mesmo remover esse registro?')){
          RequestPost({
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            fields : {
              id: id,
              type_action: 'remover_endereco',
            },
            url : '/contatos/send'
          });
        }
      }
  </script>

  <div class="modal fade" id="modalEditarEndereco" tabindex="-1" aria-labelledby="modalEditarEnderecoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="post" action="/contatos/send" enctype="multipart/form-data" class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarEnderecoLabel">Editar endereço</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                  <label>CEP*</label>
                  <input type="text" class="form-control" id="cep" name="cep" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                  <label>Rua*</label>
                  <input type="text" class="form-control" id="rua" name="rua" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Número*</label>
                  <input type="text" class="form-control" id="numero" name="numero" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Bairro*</label>
                  <input type="text" class="form-control" id="bairro" name="bairro" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Cidade*</label>
                  <input type="text" class="form-control" id="cidade" name="cidade" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Estado*</label>
                  <input type="text" class="form-control" id="estado" name="estado" />
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <input type="hidden" id="type_action" name="type_action" value="atualizar_endereco" />
          <input type="hidden" id="id" name="id" value="" />
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>

      </form>

    </div>
  </div>

  <script type="text/javascript">
      function EditarItem(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        $(".loader").show();
        $.ajax({
            type: 'post',
            url: '/contatos/send',
            data: {
              'type_action' : 'carregar_endereco',
              'id' : id
            },
            success: function(response) {
                console.log(response);
                if(response.status){
                  $("#modalEditarEndereco #id").val(response.data.id);
                  $("#modalEditarEndereco #cep").val(response.data.cep);
                  $("#modalEditarEndereco #rua").val(response.data.rua);
                  $("#modalEditarEndereco #numero").val(response.data.numero);
                  $("#modalEditarEndereco #bairro").val(response.data.bairro);
                  $("#modalEditarEndereco #cidade").val(response.data.cidade);
                  $("#modalEditarEndereco #estado").val(response.data.estado);
                }else{
                  alert(status.msg);
                }
            },
            complete: function(){
                $(".loader").hide();
            }
        });
        
        $("#modalEditarEndereco").modal();
      }
  </script>
  

  <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="post" action="/contatos/send" enctype="multipart/form-data" class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarLabel">Editar contato</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                  <label>Imagem</label>
                  <input type="file" class="form-control" id="imagem" name="imagem" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                  <label>Nome*</label>
                  <input type="text" class="form-control" id="nome" name="nome" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                  <label>E-mail*</label>
                  <input type="text" class="form-control" id="email" name="email" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Telefone*</label>
                  <input type="text" class="form-control" id="telefone" name="telefone" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                  <label>Celular</label>
                  <input type="text" class="form-control" id="celular" name="celular" />
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <input type="hidden" id="type_action" name="type_action" value="atualizar" />
          <input type="hidden" id="id" name="id" value="{{$contato->id}}" />
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>

      </form>

    </div>
  </div>

  <script type="text/javascript">
      function Editar(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        $(".loader").show();
        $.ajax({
            type: 'post',
            url: '/contatos/send',
            data: {
              'type_action' : 'carregar_contato',
              'id' : id
            },
            success: function(response) {
                console.log(response);
                if(response.status){
                  $("#modalEditar #nome").val(response.data.nome);
                  $("#modalEditar #email").val(response.data.email);
                  $("#modalEditar #telefone").val(response.data.telefone);
                  $("#modalEditar #celular").val(response.data.celular);
                }else{
                  alert(status.msg);
                }
            },
            complete: function(){
                $(".loader").hide();
            }
        });
        
        $("#modalEditar").modal();
      }
  </script>

@endsection


