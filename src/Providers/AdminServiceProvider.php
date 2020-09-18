<?php
namespace GGPHP\Admin\Providers;

use Illuminate\Support\ServiceProvider;

/**
* HelloWorld service provider
*
* @author    Jane Doe <janedoe@gmail.com>
* @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
*/
class AdminServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap services.
    *
    * @return void
    */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'gg-php');
    }

    /**
    * Register services.
    *
    * @return void
    */
    public function register()
    {
        $this->registerConfig();
        $this->registerFacades();
    }

    protected function registerFacades()
    {
        $this->app->bind(
            \Webkul\Admin\DataGrids\ProductDataGrid::class,
            \GGPHP\Admin\DataGrids\ProductDataGrid::class
        );
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );
    }
}
