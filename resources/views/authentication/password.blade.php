@extends('layout.authentication')
@section('title', 'Создание пароля')
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        <form method='POST' class="card auth_form">
            @csrf
            <input type='hidden' name='invite' value='{{ request()->gift }}' />
            <div class="header">
                <img class="logo" src="{{asset('assets/images/logo_p.png')}}" alt="">
                <h5>Создание пароля</h5>
                <span>Задайте новый пароль для вашего аккаунта Apartments4you</span>
            </div>
            <div class="body">
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Пароль" required>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Повтор пароля" required>
                </div>                        
                <button class="btn btn-primary btn-block waves-effect waves-light">ВОССТАНОВИТЬ</button>
                @if (count($errors))
                    <div class='input-group mt-3'>
                        <div class="alert alert-danger" role="alert">
                            <strong>{{$errors->first()}}</strong>
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