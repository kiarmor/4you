@extends('layout.authentication')
@section('title', 'Регистрация')
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        <form action="{{route('auth.register')}}" method='POST' class="card auth_form">
            @csrf
            <input type='hidden' name='invite' value='{{ request()->gift }}' />
            <div class="header">
                <img class="logo" src="{{asset('assets/images/logo_p.png')}}" alt="">
                <h5>Регистрация</h5>
                <span>Создайте новый аккаунт</span>
            </div>
            <div class="body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="email" placeholder="Укажите E-Mail" required>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Придумайте пароль" required>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                    </div>
                </div>                        
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="repeat" placeholder="Повторите пароль" required>
                    <div class="input-group-append">                                
                        <span class="input-group-text"><i class="zmdi zmdi-refresh"></i></span>
                    </div>                            
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="phone" placeholder="Ваш телефон" required>
                    <div class="input-group-append">                                
                        <span class="input-group-text"><i class="zmdi zmdi-smartphone-iphone"></i></span>
                    </div>                            
                </div>
                <div class="input-group mb-3">
                    @php ($referrer = request()->r ? App\User::where('id', request()->r)->first() : null)
                    <input type="text" class="form-control" name="referrer" placeholder="Укажите E-Mail наставника" @if ($referrer) value='{{ $referrer->email }}' readonly @endif required>
                    <div class="input-group-append">                                
                        <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                    </div>                            
                </div>
                <div class="checkbox">
                    <input id="remember_me" name='agreement' type="checkbox">
                    <label for="remember_me">Я прочитал(-а) <a href="https://4you.apartments/?page_id=1759" target='_blank'>условия пользования</a></label>
                </div>
                <button class="btn btn-primary btn-block waves-effect waves-light">ЗАРЕГИСТРИРОВАТЬСЯ</button>
                <div class="signin_with mt-3">
                    <a class="link" href="{{route('login')}}">Вы уже зарегистрированы?</a>
                </div>
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