# bagisto-products
Using bagisto products

### Step-1
- Download(clone) source code.
### Step-2
- `Copy` fordel `src`, then `paste` in your fordel package.
- example: `packages/GGPHP/Product/src` (`GGPHP` is your namespace, `Product` ís your package name, `src` is fordel copied)
### Step-3
- Now, to register the service provider, go to the `app.php` file inside the config folder & add your service provider inside the `providers` array.
- `GGPHP\Product\Providers\ProductServiceProvider::class`
### Step-4
- We need to add our package to the `composer.json` file of project root for auto loading in `psr-4`.
- ` "GGPHP\\Product\\": "packages/GGPHP/Product/src"`
### Step-5
- Run `composer dump-autoload`
