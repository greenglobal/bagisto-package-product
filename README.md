# bagisto-products
Using bagisto products

### Step-1
- Download(clone) source code.
### Step-2
- `Copy` fordel `src`, then `paste` in your fordel package.
- example: `packages/GGPHP/Admin/src` (`GGPHP` is your company name or namespace, `Admin` ís your package name, `src` is fordel copied)
### Step-3
- Now, to register the service provider, go to the `app.php` file inside the config folder & add your service provider inside the `providers` array.
- `GGPHP\Admin\Providers\AdminServiceProvider::class`
### Step-4
- we need to add our package to the `composer.json` file of project root for auto loading in `psr-4`.
- ` "GGPHP\\Admin\\": "packages/GGPHP/Admin/src"`
### Step-5
#### Update namespace for list file below
- `GGPHP\Admin\Providers\AdminServiceProvider`
- `GGPHP\Admin\DataGrids\ProductDataGrid`
- In file `GGPHP\Admin\Providers\AdminServiceProvider` to function `registerFacades` we need update path to `ProductDataGrid` class
### Step-6
- Run `composer dump-autoload`
