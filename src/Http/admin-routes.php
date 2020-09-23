<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix(config('app.admin_url'))->group(function () {
        // Admin Routes
        Route::group(['middleware' => ['admin']], function () {
            // Catalog Routes
            Route::prefix('catalog')->group(function () {
                // Catalog Product Routes
                Route::get('/products/create', 'Webkul\Product\Http\Controllers\ProductController@create')->defaults('_config', [
                    'view' => 'ggphp-product::admin.catalog.products.create',
                ])->name('admin.catalog.products.create');
            });
        });
    });
});
