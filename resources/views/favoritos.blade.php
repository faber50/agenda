@extends('template')

@section('main')
<br/>
<h2>Favoritos</h2>
<br/>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Nome</th>
      <th scope="col">E-mail</th>
      <th scope="col">Telefone</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>
    @if(count($contatos) > 0)
      @foreach($contatos as $contato)
      <tr>
        <td scope="row"><img src="{{$contato->imagem}}" class="figure-img img-fluid rounded-circle rounded" width="50" /></td>
        <td>{{$contato->nome}}</td>
        <td>{{$contato->email}}</td>
        <td>{{$contato->telefone}}</td>
        <td>
          <a href="{{url('contatos/detalhe')}}/{{$contato->id}}" class="btn btn-success"><i class="far fa-eye"></i></a>
          @auth
          <a href="javascript:void(0);" onclick="RemoverItem({{$contato->id}});" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
          <a href="javascript:void(0);" onclick="FavoritarItem({{$contato->id}},{{(($contato->favorito) ? 'false' : 'true')}});" class="btn btn-warning"><i class="{{(($contato->favorito) ? 'fas' : 'far')}} fa-heart"></i></a>
          @endauth
        </td>
      </tr>
      @endforeach
    @else
      <tr>
        <td colspan="5">Nenhum registro encontrado</td>
      </tr>
    @endif
  </tbody>
  <script type="text/javascript">
      function RemoverItem(id) {
        if(confirm('Deseja mesmo remover esse registro?')){
          RequestPost({
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            fields : {
              id: id,
              type_action: 'remover',
            },
            url : '/contatos/send'
          });
        }
      }
      function FavoritarItem(id,remover) {
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
      </script>
  </table>
</table>
@endsection


