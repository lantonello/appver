# AppVer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codimais/appver.svg?style=flat-square)](https://packagist.org/packages/codimais/appver)
[![Total Downloads](https://img.shields.io/packagist/dt/codimais/appver.svg?style=flat-square)](https://packagist.org/packages/codimais/appver)
![GitHub Actions](https://github.com/codimais/laraversion/actions/workflows/main.yml/badge.svg)

Controls semantic versioning of your Laravel application with easy

## Installation

You can install the package via composer:

```bash
composer require codimais/appver
```

After installing the package in your project, go to the terminal and run the below command to initialize **AppVer**:

```bash
php artisan appver:init
```

The command will ask if you want to boot with a specific version. You can accept the default, which is **"1.0.0"**.

It will also try to identify if your project has a git repository and, if so, it will offer to create a git hook to automate the version increment.

## Usage

### Auto increment

If your project has a git repository and if **AppVer** was able to create the _pre-commit hook_, you don't need to do anything.

Before each _commit_, git will run the _pre-commit hook_ that will increment the version of your application and add it to the current _commit_, automatically.

### Manual increment

If your project is not in a git repository or if you do not want to use auto increment, then you can increment the version of your application manually:

```bash
// To increment the patch number:
php artisan appver:inc --patch
// Output: Version changed from '1.0.0' to '1.0.1'

// To increment the minor version number:
php artisan appver:inc --minor
// Output: Version changed from '1.0.0' to '1.1.0'

// To increment the major version number:
php artisan appver:inc --major
// Output: Version changed from '1.0.0' to '2.0.0'
```

You can combine the increments as you need. The order does not matter.

```bash
php artisan appver:inc --patch --minor
// Output: Version changed from '1.0.0' to '1.1.1'

php artisan appver:inc --major --minor
// Output: Version changed from '1.0.0' to '2.1.0'

php artisan appver:inc --minor --major --patch
// Output: Version changed from '1.0.0' to '2.1.1'
```

If you need to display the current version in your API or in a View:

```php
<?php
 
namespace App\Http\Controllers;
 
use Codimais\AppVer\AppVer;
 
class MyController extends Controller
{
    /**
     * Show something
     */
    public function show(): View
    {
        $appver = new AppVer();

        return view('my.view', [
            'app_version' => $appver->get()
        ]);
    }
}
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email lantonello@gmail.com instead of using the issue tracker.

## Credits

-   [Leandro Antonello](https://github.com/codimais)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
