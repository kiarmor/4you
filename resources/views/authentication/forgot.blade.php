@extends('layout.authentication')
@section('title', 'Восстановление пароля')
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        <form class="card auth_form" method='POST'>
            @csrf
            <div class="header">
                <img class="logo" src="{{asset('assets/images/logo_p.png')}}" alt="">
                <h5>Забыли пароль?</h5>
                <span>Введите ваш E-Mail адрес и мы вышлем вам письмо для его восстановления.</span>
            </div>
            <div class="body">
                <div class="input-group mb-3">
                    <input type="text" name='email' class="form-control" placeholder="Ваш E-Mail">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                    </div>
                </div>
                <button class="btn btn-primary btn-block waves-effect waves-light">ОТПРАВИТЬ</button>
                <div class="signin_with mt-3">
                    <a class="link" href="{{route('login')}}">Вернуться к авторизации</a>
                </div>
                @if (count($errors))
                    <div class='input-group mt-3'>
                        <div class="alert alert-danger text-center" role="alert">
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
@stop