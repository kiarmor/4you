
@php ($link = 'https://my.4you.apartments/complete-reset?qk=' . md5($user->id . ':' . $user->email . '->' . $user->reset_key). '&from=' . $user->email)
Здравствуйте! На проекте Apartments4you была инициирована процедура восстановления пароля.
<br><br>
Если это сделали вы и действительно хотите восстановить пароль, то перейдите по ссылке для смены пароля: <a href="{{$link}}">{{$link}}</a>
<br><br>
Если вы не пытались восстановить пароль, то рекомендуем вам предпринять следующие меры для того, чтобы обезопасить себя:<br>
1) Сменить пароль аккаунта Apartments4you<br>
2) Сменить пароль от вашей почты<br>
<br><br>
<br>
С уважением, команда 4you.apartments