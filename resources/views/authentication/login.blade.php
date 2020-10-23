@extends('layout.authentication')
@section('title', 'Авторизация')
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        <form action="{{route('auth.login')}}" method='POST' class="card auth_form">
            @csrf
            <div class="header">
                <img class="logo" src="{{asset('assets/images/logo_p.png')}}" alt="">
                <h5>Вход</h5>
                <h2>@lang('auth.failed')</h2>

            </div>
            <div class="body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name='email' placeholder="E-Mail" required>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                    </div>
                </div>
                <div class="input-group mb-1">
                    <input type="password" class="form-control" name='password' placeholder="Пароль" required>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                    </div>
                </div>
                <div class="input-group ml-1 mb-3">
                    <a href="{{route('authentication.forgot')}}">Потеряли пароль?</a>
                </div>
                <div class="checkbox">
                    <input id="remember_me" name='remember_me' type="checkbox">
                    <label for="remember_me">Запомнить меня</label>
                </div>
                <button class="btn btn-primary btn-block waves-effect waves-light">ВОЙТИ</button>
                <div class="signin_with mt-3">
                    <a href="{{route('authentication.register')}}">или зарегистрироваться</a>
                </div>
                @if (count($errors))
                    <div class='input-group mt-3'>
                        <div class="alert alert-danger" role="alert">
                            <strong>{{$errors->first()}}</strong>
                        </div>
                    </div>
                @endif
                @if(session()->has('message'))
                    <div class='input-group mt-3'>
                        <div class="alert alert-success w-100 text-center" role="alert">
                            <strong>{{ session()->get('message') }}</strong>
                        </div>
                    </div>
                @endif
            </div>
        </form>
        <div class="copyright text-center">
            <script>document.write(new Date().getFullYear())</script> &copy;
            <span>Apartments4you</span>
        </div>
    </div>
    <div class="col-lg-8 col-sm-12 align-items-center d-flex">
        <div class="card">
            <img src="{{asset('assets/images/logo_small.png')}}" alt="Sign Up" />
        </div>
    </div>
</div>
<body>
<div id="app">
    <div style="background-color: #343a40;">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark frames-container">
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ml-auto">
                    @php $locale = /*session()->get('locale');*/ app()->setLocale('en') @endphp
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @switch($locale)
                                @case('us')
                                 English
                                @break
                                @case('ru')
                                 Русский
                                @break
                                @default
                                 English
                            @endswitch
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="lang/en"> English</a>
                            <a class="dropdown-item" href="lang/ru"> Русский</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

</div>
</body>
</html>
@stop
