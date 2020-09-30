# bagisto-products
## Features
- Admin able custom products listing or show parent products only
- Admin able custom config product types suiable with your project
- Auto fill name, url key for variants
- Admin able set value channel as default and hidden it
- Admin able set value attribute family as default when create new product

## Using bagisto products

### Step-1
- Download(clone) source code.
### Step-2
- Inside folder `packages` create new folder `GGPHP`, inside folder `GGPHP` create folder `Product`
- `Copy` folder `src`, then `paste` in folder `Product`.
- example: `packages/GGPHP/Product/src`
### Step-3
- Now, to register the service provider, go to the `app.php` file inside the config folder & add your service provider inside the `providers` array.
- `GGPHP\Product\Providers\ProductServiceProvider::class`
### Step-4
- we need to add our package to the `composer.json` file of project root for auto loading in `psr-4`.
- ` "GGPHP\\Product\\": "packages/GGPHP/Product/src"`
### Step-5
- Run `composer dump-autoload`
- Run `php artisan route:cache`
- Go to `https://<your-site>/admin/configuration/catalog/products`
