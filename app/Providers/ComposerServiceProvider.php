<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {        
        View::composer('admin.template', 'App\Http\ViewComposers\Admin\IsnewComposer');                
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {}
}
