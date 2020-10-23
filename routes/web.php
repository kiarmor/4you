<?php

Route::get('test', function () {
   dd(\App\User::where('referrer_id', '!=', null)->first());
});

Route::auth();

Route::middleware('auth')->group(function() {
	Route::get('/', function () { return redirect('dashboard/index'); });

	/* Dashboard */
	Route::get('dashboard', function () { return redirect('dashboard/index'); });
	Route::get('dashboard/index', 'DashboardController@index')->name('dashboard.index');

	/* Profile */
	//Route::get('profile', function () { return redirect('profile/my-profile'); });
	//Route::get('profile/my-profile', 'ProfileController@myProfile')->name('profile.my-profile');

	/* App */
	Route::get('app', function () { return redirect('app/inbox'); });
	Route::get('app/inbox', 'AppController@inbox')->name('app.inbox');
	Route::get('app/compose', 'AppController@compose')->name('app.compose');
	Route::get('app/single', 'AppController@single')->name('app.single');
	Route::get('app/chat', 'AppController@chat')->name('app.chat');
	Route::get('app/calendar', 'AppController@calendar')->name('app.calendar');
	Route::get('app/contact-list', 'AppController@contactList')->name('app.contact-list');

	/* Project */
	Route::get('project', function () { return redirect('project/project-list'); });
	Route::get('project/project-list', 'ProjectController@projectList')->name('project.project-list');
	Route::get('project/taskboard', 'ProjectController@taskboard')->name('project.taskboard');
	Route::get('project/ticket-list', 'ProjectController@ticketList')->name('project.ticket-list');
	Route::get('project/ticket-detail', 'ProjectController@ticketDetail')->name('project.ticket-detail');

	/* File Manager */
	Route::get('file-manager', function () { return redirect('file-manager/all'); });
	Route::get('file-manager/all', 'FileManagerController@all')->name('file-manager.all');
	Route::get('file-manager/documents', 'FileManagerController@documents')->name('file-manager.documents');
	Route::get('file-manager/media', 'FileManagerController@media')->name('file-manager.media');
	Route::get('file-manager/image', 'FileManagerController@image')->name('file-manager.image');

	/* Blog */
	Route::get('blog', function () { return redirect('blog/dashboard'); });
	Route::get('blog/dashboard', 'BlogController@dashboard')->name('blog.dashboard');
	Route::get('blog/new-post', 'BlogController@newPost')->name('blog.new-post');
	Route::get('blog/list', 'BlogController@list')->name('blog.list');
	Route::get('blog/grid', 'BlogController@grid')->name('blog.grid');
	Route::get('blog/detail', 'BlogController@detail')->name('blog.detail');

	/* Ecommerce */
	Route::get('ecommerce', function () { return redirect('ecommerce/dashboard'); });
	Route::get('ecommerce/dashboard', 'EcommerceController@dashboard')->name('ecommerce.dashboard');
	Route::get('ecommerce/product', 'EcommerceController@product')->name('ecommerce.product');
	Route::get('ecommerce/product-list', 'EcommerceController@productList')->name('ecommerce.product-list');
	Route::get('ecommerce/product-detail', 'EcommerceController@productDetail')->name('ecommerce.product-detail');

	/* components */
	Route::get('components', function () { return redirect('components/ui'); });
	Route::get('components/ui', 'ComponentsController@ui')->name('components.ui');
	Route::get('components/alerts', 'ComponentsController@alerts')->name('components.alerts');
	Route::get('components/collapse', 'ComponentsController@collapse')->name('components.collapse');
	Route::get('components/colors', 'ComponentsController@colors')->name('components.colors');
	Route::get('components/dialogs', 'ComponentsController@dialogs')->name('components.dialogs');
	Route::get('components/list', 'ComponentsController@list')->name('components.list');
	Route::get('components/media', 'ComponentsController@media')->name('components.media');
	Route::get('components/modals', 'ComponentsController@modals')->name('components.modals');
	Route::get('components/notifications', 'ComponentsController@notifications')->name('components.notifications');
	Route::get('components/progressbars', 'ComponentsController@progressbars')->name('components.progressbars');
	Route::get('components/range', 'ComponentsController@range')->name('components.range');
	Route::get('components/sortable', 'ComponentsController@sortable')->name('components.sortable');
	Route::get('components/tabs', 'ComponentsController@tabs')->name('components.tabs');
	Route::get('components/waves', 'ComponentsController@waves')->name('components.waves');

	/* Font Icons */
	Route::get('icons', function () { return redirect('icons/material'); });
	Route::get('icons/material', 'IconsController@material')->name('icons.material');
	Route::get('icons/themify', 'IconsController@themify')->name('icons.themify');
	Route::get('icons/weather', 'IconsController@weather')->name('icons.weather');

	/* Form */
	Route::get('form', function () { return redirect('form/basic'); });
	Route::get('form/basic', 'FormController@basic')->name('form.basic');
	Route::get('form/advanced', 'FormController@advanced')->name('form.advanced');
	Route::get('form/examples', 'FormController@examples')->name('form.examples');
	Route::get('form/validation', 'FormController@validation')->name('form.validation');
	Route::get('form/wizard', 'FormController@wizard')->name('form.wizard');
	Route::get('form/editors', 'FormController@editors')->name('form.editors');
	Route::get('form/upload', 'FormController@upload')->name('form.upload');
	Route::get('form/summernote', 'FormController@summernote')->name('form.summernote');

	/* Tables */
	Route::get('tables', function () { return redirect('tables/normal'); });
	Route::get('tables/normal', 'TablesController@normal')->name('tables.normal');
	Route::get('tables/datatable', 'TablesController@datatable')->name('tables.datatable');
	Route::get('tables/editable', 'TablesController@editable')->name('tables.editable');
	Route::get('tables/footable', 'TablesController@footable')->name('tables.footable');
	Route::get('tables/color', 'TablesController@color')->name('tables.color');

	/* Chart */
	Route::get('chart', function () { return redirect('chart/echarts'); });
	Route::get('chart/echarts', 'ChartController@echarts')->name('chart.echarts');
	Route::get('chart/c3', 'ChartController@c3')->name('chart.c3');
	Route::get('chart/morris', 'ChartController@morris')->name('chart.morris');
	Route::get('chart/flot', 'ChartController@flot')->name('chart.flot');
	Route::get('chart/chartjs', 'ChartController@chartjs')->name('chart.chartjs');
	Route::get('chart/sparkline', 'ChartController@sparkline')->name('chart.sparkline');
	Route::get('chart/knob', 'ChartController@knob')->name('chart.knob');

	/* Widgets */
	Route::get('widgets', function () { return redirect('widgets/app'); });
	Route::get('widgets/app', 'WidgetsController@app')->name('widgets.app');
	Route::get('widgets/data', 'WidgetsController@data')->name('widgets.data');

	/* Pages */
	Route::get('pages', function () { return redirect('pages/blank-page'); });
	Route::get('pages/blank', 'PagesController@blank')->name('pages.blank');
	Route::get('pages/gallery', 'PagesController@gallery')->name('pages.gallery');
	Route::get('pages/invoices1', 'PagesController@invoices1')->name('pages.invoices1');
	Route::get('pages/invoices2', 'PagesController@invoices2')->name('pages.invoices2');
	Route::get('pages/pricing', 'PagesController@pricing')->name('pages.pricing');
	Route::get('pages/profile', 'PagesController@profile')->name('pages.profile');
	Route::get('pages/search', 'PagesController@search')->name('pages.search');
	Route::get('pages/timeline', 'PagesController@timeline')->name('pages.timeline');

	/* Maps */
	Route::get('map', function () { return redirect('map/google'); });
	Route::get('map/yandex', 'MapController@yandex')->name('map.yandex');
	Route::get('map/jvector', 'MapController@jvector')->name('map.jvector');

	/* */
	Route::get('profile', 'ProfileController@profile')->name('profile');
	Route::get('gifts', 'GiftsController@index')->name('profile.gifts');
	Route::get('referrals', 'ProfileController@referrals')->name('profile.referrals');
	Route::get('referrals/{id}/', 'ProfileController@more')->name('profile.more');
	Route::get('payments', 'ProfileController@payments')->name('profile.payments');
	Route::get('tariff', 'TariffController@index')->name('tariff.index');
	Route::get('purchases', 'TariffController@my')->name('tariff.my');
	Route::get('withdraw', 'WithdrawController@index')->name('payout.new');
	Route::get('payment', 'PaymentController@index')->name('payment.index');
	Route::get('transfer', 'TransferController@index')->name('transfer.index');
	Route::get('ticket', 'TicketController@index')->name('ticket.index');
	Route::get('ticket/more/{id}', 'TicketController@more')->name('ticket.more');
	Route::get('ticket/create', 'TicketController@create')->name('ticket.create');
	Route::post('ticket/more/{id}', 'TicketController@sendMessage');
	Route::post('ticket/create', 'TicketController@createPost');
	Route::any('payment/success', 'PaymentController@success')->name('payment.success');
	Route::any('payment/bad', 'PaymentController@bad')->name('payment.bad');
	Route::post('transfer', 'TransferController@index')->name('transfer.index');
 
	Route::post('payment', 'PaymentController@submit')->name('payment.submit');

	/* Handlers */
	Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');
	Route::post('handlers/profile', 'ProfileController@update')->name('profile.update');
	Route::post('hanlers/sendGift', 'GiftsController@send')->name('gifts.send');
	Route::post('tariff', 'TariffController@purchase');
	Route::post('withdraw', 'WithdrawController@create');
	Route::post('changepass', 'ProfileController@password')->name('profile.change.password');
	Route::post('getpin', 'ProfileController@getpin');
	Route::get('history/export/', 'ExcelController@export')->name('history.export');
	Route::post('gifts', 'GiftsController@handle');

	/* Admin */
	Route::middleware('admin')->group(function() {
		Route::get('admin', 'Admin\UsersController@index')->name('admin.users');
		Route::get('admin/{user}/referrals', 'Admin\UsersController@referrals')->name('admin.users.referrals');
		Route::get('admin/edit', 'Admin\UsersController@edit')->name('admin.users.edit');
		Route::get('admin/delete', 'Admin\UsersController@delete')->name('admin.users.delete');
		Route::get('admin/history', 'Admin\UsersController@history')->name('admin.users.history');
		Route::post('admin/edit', 'Admin\UsersController@save');
		Route::get('admin/tariff', 'Admin\TariffController@index')->name('admin.tariff');
		Route::get('admin/tariff/edit', 'Admin\TariffController@edit')->name('admin.tariff.edit');
		Route::post('admin/tariff/edit', 'Admin\TariffController@save');
		Route::get('admin/tariff/delete', 'Admin\TariffController@delete')->name('admin.tariff.delete');
		Route::get('admin/groups', 'Admin\GroupsController@index')->name('admin.groups');
		Route::get('admin/groups/edit', 'Admin\GroupsController@edit')->name('admin.groups.edit');
		Route::post('admin/groups/edit', 'Admin\GroupsController@save');
		Route::get('admin/groups/delete', 'Admin\GroupsController@delete')->name('admin.groups.delete');
		Route::get('admin/active', 'Admin\ActiveController@index')->name('admin.active');
		Route::get('admin/active/history', 'Admin\ActiveController@history')->name('admin.active.history');
		Route::get('admin/active/edit/{id}', 'Admin\ActiveController@edit');
		Route::post('admin/active/update/{id}', 'Admin\ActiveController@update');
		Route::get('admin/settings', 'Admin\SettingsController@index')->name('admin.settings');
		Route::post('admin/settings', 'Admin\SettingsController@save');
		Route::get('admin/withdraw', 'Admin\WithdrawController@index')->name('admin.withdraw');
		Route::get('admin/withdraw/accept', 'Admin\WithdrawController@accept')->name('admin.withdraw.accept');
		Route::get('admin/withdraw/decline', 'Admin\WithdrawController@decline')->name('admin.withdraw.decline');
		Route::get('admin/gifts', 'Admin\GiftsController@index')->name('admin.gifts');
		Route::get('admin/gifts/edit', 'Admin\GiftsController@edit')->name('admin.gifts.edit');
		Route::get('admin/gifts/delete', 'Admin\GiftsController@delete')->name('admin.gifts.delete');
		Route::post('admin/gifts/edit', 'Admin\GiftsController@save')->name('admin.gifts.save');
		Route::get('admin/gifts/history', 'Admin\GiftsController@history')->name('admin.gifts.history');
		Route::get('admin/ticket', 'Admin\TicketController@index')->name('admin.ticket');
		Route::get('admin/ticket/{id}', 'Admin\TicketController@more')->name('admin.ticket.more');
		Route::post('admin/ticket/{id}', 'Admin\TicketController@sendMessage');
		Route::get('admin/ticket/close/{id}', 'Admin\TicketController@close')->name('admin.ticket.close');
    /* Transfers */
    Route::get('admin/transfers', 'Admin\TransferController@index')->name('admin.transfers');    
	});
});

Route::get('clear', function () {
	// foreach (User::get() as $user) {
	// 	$user->total_partners = $user->network();
	// 	$user->total_purchased = App\Purchased::where('user_id', $user->id)->where('active', true)->count();
	// 	$user->total_volume = $user->volume();
	// 	$user->save();
	// }
    Log::debug('CLEARED');
    // Artisan::call('migrate');
    Artisan::call('storage:link');
    // Artisan::call('cache:clear');
    // Artisan::call('config:cache');
    // Artisan::call('vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"');
    // Artisan::call('config:cache');
    // Artisan::call('storage:link');
});

Route::get('/', function () { return redirect('login'); });

/* Handlers */
Route::post('register', 'Auth\RegisterController@register')->name('auth.register');
Route::post('login', 'Auth\LoginController@login')->name('auth.login');
Route::get('complete-reset', 'AuthenticationController@resetPassword');
Route::post('complete-reset', 'AuthenticationController@completeReset');
Route::post('payment/handle', 'PaymentController@handler')->name('payment.handler');
Route::get('payment/handle', 'PaymentController@handler')->name('payment.handler');
Route::any('payment/payeer', 'PayeerController@handler')->name('payeer.handler');


/* Authentication */
Route::get('login', 'AuthenticationController@login')->name('login');
Route::get('register', 'AuthenticationController@register')->name('authentication.register');
Route::get('forgot', 'AuthenticationController@forgot')->name('authentication.forgot');
Route::post('forgot', 'AuthenticationController@forgotSend')->name('auth.reset');

/* Data */
Route::get('confirm', 'AuthenticationController@confirm');
// Route::get('authentication/lockscreen', 'AuthenticationController@lockscreen')->name('authentication.lockscreen');
// Route::get('authentication/page404', 'AuthenticationController@page404')->name('authentication.page404');
// Route::get('authentication/page500', 'AuthenticationController@page500')->name('authentication.page500');
// Route::get('authentication/offline', 'AuthenticationController@offline')->name('authentication.offline');
