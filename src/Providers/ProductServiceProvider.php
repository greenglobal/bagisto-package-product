<?php
namespace GGPHP\Product\Providers;

use Illuminate\Support\ServiceProvider;

/**
* HelloWorld service provider
*
* @author    Jane Doe <janedoe@gmail.com>
* @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
*/
class ProductServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap services.
    *
    * @return void
    */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'ggphp');
        $this->composeView();
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
            \GGPHP\Product\DataGrids\ProductDataGrid::class
        );
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );
    }

    protected function composeView()
    {
        view()->composer(['admin::catalog.products.create'], function ($view) {
            $productTypes = [];
            $defaultConfig = config('product_types');
            $customConfig = explode(',', core()->getConfigData('catalog.products.general.list-product-type'));

            // If there exists an admin-customized product type data, update it
            if (! empty($customConfig[0])) {
                foreach ($defaultConfig as $item) {
                    if (in_array($item['key'], $customConfig)) {
                        $item['children'] = [];
                        array_push($productTypes, $item);
                    }
                }
            } else {
                foreach ($defaultConfig as $item) {
                    $item['children'] = [];
                    array_push($productTypes, $item);
                }
            }

            $types = core()->sortItems($productTypes);

            $view->with('productTypes', $types);
        });
    }
}
