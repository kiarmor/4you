<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="{{route('dashboard.index')}}" class='ml-3'><img src="/assets/images/logo_p.png" width="100" alt="Apartments4you"></a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <!-- <div class="image"><a href="#"><img src="../assets/images/profile_av.jpg" alt="User"></a></div> -->
                    <div class='col-12 py-1 justify-content-center'>
                        <div class='mb-1'>
                            <strong>{{ Auth::user()->email }}</strong>
                        </div>
                        <small class='text-success'><strong>{{ Auth::user()->balance }}</strong> USD</small>
                    </div>
                </div>
            </li>
            <li class="{{ Request::segment(1) === 'dashboard' ? 'active open' : null }}"><a href="{{route('dashboard.index')}}"><i class="zmdi zmdi-home"></i><span>Рабочий стол</span></a></li>
            <li class="{{ Request::segment(1) === 'referrals' ? 'active open' : null }}"><a href="{{route('profile.referrals')}}"><i class="zmdi zmdi-accounts-alt"></i><span>Моя сеть</span></a></li>
            <li class="{{ Request::segment(1) == 'tariff' ? 'active open' : null }}"><a href="{{route('tariff.index')}}"><i class="zmdi zmdi-shopping-cart"></i><span>Магазин</span></a></li>
            <!-- <li class="{{ Request::segment(1) == 'payment' ? 'active open' : null }}"><a href="#"><i class="zmdi zmdi-money"></i><span>Мои выплаты</span></a></li> -->
            <li class="{{ Request::segment(1) === 'payments' ? 'active open' : null }}"><a href="{{route('profile.payments')}}"><i class="zmdi zmdi-money"></i><span>Мои выплаты</span></a></li>
            <li class="{{ Request::segment(1) == 'purchases' ? 'active open' : null }}"><a href="{{route('tariff.my')}}"><i class="zmdi zmdi-shopping-basket"></i><span>Мои покупки</span></a></li>
            <li class="{{ Request::segment(1) == 'gifts' ? 'active open' : null }}"><a href="{{ route('profile.gifts') }}"><i class="zmdi zmdi-card-giftcard"></i><span>Подарочные сертификаты</span></a></li>
            <!-- <li class="{{ Request::segment(1) == 'payment' ? 'active open' : null }}"><a href="#"><i class="zmdi zmdi-bookmark"></i><span>Новости</span></a></li> -->
            <li class="{{ Request::segment(1) == 'profile' ? 'active open' : null }}"><a href="{{ route('profile') }}"><i class="zmdi zmdi-account-o"></i><span>Профиль</span></a></li>
            <li class="{{ Request::segment(1) == 'payment' ? 'active open' : null }}"><a href="{{ route('payment.index') }}"><i class="zmdi zmdi-money-box"></i><span>Пополнить баланс</span></a></li>
            <li class="{{ Request::segment(1) == 'transfer' ? 'active open' : null }}"><a href="{{ route('transfer.index') }}"><i class="zmdi zmdi-money-box"></i><span>Перевод средств</span></a></li>
            <li class="{{ Request::segment(1) == 'ticket' ? 'active open' : null }}"><a href="{{ route('ticket.index') }}"><i class="zmdi zmdi-receipt"></i><span>Тикеты</span></a></li>
            @if (Auth::user()->isadmin) <li><a href="{{ route('admin.users') }}"><i class="zmdi zmdi-smartphone-setup"></i><span>Админ-панель</span></a></li> @endif
             <li class="{{ Request::segment(1) == 'logout' ? 'active open' : null }} mb-3"><a href="{{ route('logout') }}"><i class="zmdi zmdi-power"></i><span>Выйти</span></a></li>
        </ul>
    </div>
</aside>
