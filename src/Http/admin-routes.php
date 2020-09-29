<?php
Route::group(['middleware' => ['web']], function () {
    Route::prefix(config('app.admin_url'))->group(function () {
        Route::group(['middleware' => ['admin']], function () {
            Route::prefix('catalog')->group(function () {
                Route::get('/products/edit/{id}', 'Webkul\Product\Http\Controllers\ProductController@edit')->defaults('_config', [
                    'view' => 'ggphp-product::admin.catalog.products.edit',
                ])->name('admin.catalog.products.edit');
                Route::get('/products/create', 'Webkul\Product\Http\Controllers\ProductController@create')->defaults('_config', [
                    'view' => 'ggphp-product::admin.catalog.products.create',
                ])->name('admin.catalog.products.create');
            });
        });
    });
});
