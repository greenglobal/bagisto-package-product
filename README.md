# bagisto-products
## Features
- Admin able custom list all products or show parent products only
- Admin able custom configuration product types suiable with your project

## Using bagisto products

### Step-1
- Download(clone) source code.
### Step-2
- Inside fordel `packages` create new fordel `GGPHP`, inside fordel `GGPHP` create fordel `Admin`
- `Copy` fordel `src`, then `paste` in fordel `Admin`.
- example: `packages/GGPHP/Admin/src`
### Step-3
- Now, to register the service provider, go to the `app.php` file inside the config folder & add your service provider inside the `providers` array.
- `GGPHP\Admin\Providers\AdminServiceProvider::class`
### Step-4
- we need to add our package to the `composecustomr.json` file of project root for auto loading in `psr-4`.
- ` "GGPHP\\Admin\\": "packages/GGPHP/Admin/src"`
### Step-5
- Run `composer dump-autoload`
