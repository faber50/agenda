<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Agenda</title>
        <script type="text/javascript" src="/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/jquery.mask.js"></script>
        <script type="text/javascript" src="/js/ajax.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-grid.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-reboot.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="/fontawesome/css/all.min.css" />
        <style type="text/css">
        .loader{
            width: 100%;
            height: 100%;
            position: fixed;
            align-items: center;
            justify-content: center;
            display: inline-flex;
            background: rgba(255,255,255,0.8);
            z-index: 99999;
        }
        </style>
    </head>
    <body>
        <div class="loader" style="display:none;">
            <div class="spinner-border text-primary" role="status"></div>
        </div>

        <div class="container">
            <h1>Minha Agenda</h1>
            <br/>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item {{ ((Route::current()->getName() == 'contatos') ? 'active' : '') }}">
                            <a class="nav-link" href="{{url('contatos')}}">Contatos</a>
                        </li>
                        <li class="nav-item {{ ((Route::current()->getName() == 'favoritos') ? 'active' : '') }}">
                            <a class="nav-link" href="{{url('contatos/favoritos')}}">Favoritos</a>
                        </li>

                        @if (Auth::guest())
                            <li class="nav-item {{ ((Route::current()->getName() == 'login') ? 'active' : '') }}">
                                <a class="nav-link" href="{{url('login')}}">Login</a>
                            </li>
                            <li class="nav-item {{ ((Route::current()->getName() == 'cadastro') ? 'active' : '') }}">
                                <a class="nav-link" href="{{url('cadastro')}}">Cadastro</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('logout')}}">Logout</a>
                            </li>
                        @endif

                    </ul>
                    @auth
                    <a href="{{url('contatos/novo')}}" class="btn btn-primary">Novo contato</a>
                    @endauth
                </div>
            </nav>
            <div class="container ">
                @yield('main')
            </div>
        </div>
        <script type="text/javascript">
        $('form').on('submit', function(e) {
            e.preventDefault(); 
            var formData = new FormData($(this)[0]);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $(".loader").show();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                //contentType : 'multipart/form-data',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if(response.status){
                        if(response.redirect){
                            window.location.href = response.redirect;
                        }
                        if(response.reload){
                            document.location.reload(true);
                        }
                        if(response.msg){
                            alert(response.msg);
                        }
                    }else{
                        alert(response.msg);
                    }
                },
                error: function(response){
                    console.log(response.responseJSON);
                    if(response.responseJSON){
                        if(response.responseJSON.errors){
                            var listErrors = '';
                            $.each( response.responseJSON.errors, function( key, value ) {
                                listErrors += '- '+value+'\n';
                            });
                            alert(listErrors);
                        }
                    }else{
                        console.log(response.responseText);
                        alert('Ops, ocorreu um erro ao tentar enviar os dados');
                        $(".loader").hide();
                    }
                },
                complete: function(){
                    $(".loader").hide();
                }
            });
        });
        </script>
    </body>
</html>
