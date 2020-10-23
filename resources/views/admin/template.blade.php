<!DOCTYPE HTML>
<html lang='ru'>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>@yield('title', 'Панель администратора') – Apartments4you</title>

		<script src="https://kit.fontawesome.com/6d1b59ad1f.js" crossorigin="anonymous"></script>
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		<link href="{{asset('assets/admin/sb-admin-2.min.css')}}" rel="stylesheet">
	</head>

	<body>
		<div id="wrapper">
			<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
				<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
					<div class="sidebar-brand-text mx-3">Apartments<sup>4</sup>you</div>
				</a>

				<hr class="sidebar-divider mt-0">
				<div class="sidebar-heading d-none d-md-block">Пользователи</div>
				<li class="nav-item {{ Request::segment(1) === 'admin' && Request::segment(2) == '' ? 'active' : null }}">
					<a class="nav-link" href="{{route('admin.users')}}">
						<i class="fas fa-users"></i>
						<span>Список людей</span>
						@if ($newUsersQ)
							&nbsp;
							<span class="badge badge-danger">{{$newUsersQ}}</span>
						@endif
					</a>
				</li>
				<li class="nav-item {{ Request::segment(2) == 'groups' ? 'active' : null }}">
					<a class="nav-link" href="{{route('admin.groups')}}">
						<i class="fas fa-layer-group"></i>
						<span>Группы</span>
					</a>
				</li>

				<hr class="sidebar-divider mb-0">
				<li class="nav-item {{ Request::segment(2) == 'tariff' ? 'active' : null }}">
					<a class="nav-link" href="{{route('admin.tariff')}}">
						<i class="fas fa-money-check-alt"></i>
						<span>Сертификаты</span>
					</a>
				</li>
				<li class="nav-item {{ Request::segment(2) == 'active' ? 'active' : null }}">
					<a class="nav-link" href="{{route('admin.active')}}">
						<i class="fas fa-dollar-sign"></i>
						<span>Активные сертификаты</span>
					</a>
				</li>
				<li class="nav-item {{ Request::segment(2) == 'gifts' ? 'active' : null }}">
					<a class="nav-link" href="{{route('admin.gifts')}}">
						<i class="fas fa-gifts"></i>
						<span>Подарочные сертификаты</span>
					</a>
				</li>

				<hr class="sidebar-divider mb-0">
				<!-- <li class="nav-item {{ Request::segment(2) == 'settings' ? 'active' : null }}">
					<a class="nav-link" href="{{route('admin.settings')}}">
						<i class="fas fa-cog"></i>
						<span>Настройки сайта</span>
					</a>
				</li> -->
				<li class="nav-item {{ Request::segment(2) == 'withdraw' ? 'active' : null }}">
					<a class="nav-link" href="{{route('admin.withdraw')}}">
						<i class="fas fa-wallet"></i>
						<span>Заявки на вывод</span>
						@if ($newWithdrawsQ)
							&nbsp;
							<span class="badge badge-danger">{{$newWithdrawsQ}}</span>
						@endif
					</a>
				</li>

				<li class="nav-item {{ Request::segment(2) == 'ticket' ? 'active' : null }}">
					<a class="nav-link" href="{{route('admin.ticket')}}">
						<i class="fas fa-clipboard-list"></i>
						<span>Тикеты</span>
						@if ($newTicketsQ)
							&nbsp;
							<span class="badge badge-danger">{{$newTicketsQ}}</span>
						@endif
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="#">
						<i class="fas fa-paste"></i>
						<span>Отчёты</span>
					</a>
				</li>

				<li class="nav-item {{ Request::segment(2) == 'transfers' ? 'active' : null }}">
					<a class="nav-link" href="{{ route('admin.transfers') }}">
						<i class="fas fa-dollar-sign"></i>
						<span>Переводы</span>
					</a>
				</li>
			</ul>

			<div id="content-wrapper" class="d-flex flex-column">
				<div id="content">
					<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item dropdown no-arrow">
								<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->email}} <strong><i class="fas fa-arrow-down"></i></strong></span>
								</a>

								<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
									<a class="dropdown-item" href="{{route('dashboard.index')}}">
										<i class="fas fa-undo"></i>
										Вернуться на сайт
									</a>
									<a class="dropdown-item" href="{{route('logout')}}">
										<i class="fas fa-sign-out-alt"></i>
										Выйти
									</a>
								</div>
							</li>
						</ul>
					</nav>

					<div class='container-fluid'>
						@yield('content')
					</div>
     			</div>
     		</div>
		</div>
		<script src="{{asset('assets/admin/jquery.min.js')}}"></script>
  		<script src="{{asset('assets/admin/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('assets/admin/jquery.easing.min.js')}}"></script>
		<script src="{{asset('assets/admin/sb-admin-2.min.js')}}"></script>
		@yield('scripts')
	</body>
</html>
