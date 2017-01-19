# Laravel Versioner

This tool allows to generate project versions in [Laravel](https://laravel.com/) and [Git](https://git-scm.com/).

The versions are generated in Git as tags with the format `vX.Y.Z`. When generating a new vesion, this tool gets the latest git version tag and increseases it, depending on the type of release you want to generate.

### Requirements

- PHP >= 5.6
- Laravel >= 5.0

### Instalation

You only need to add the package to your `composer.json` file.
```sh
composer require xxxxxxx
```

### Command

To generate a new version you have to execute the artisan command `php artisan versioner:git:generate` and pass the type of the release you'd like to generate. There are three realease options:
- **release**: increases the X
- **beta**: increases the Y
- **alpha**: increases the Z

```sh
php artisan versioner:git:generate release
```
```sh
php artisan versioner:git:generate beta
```
```sh
php artisan versioner:git:generate alpha
```

### Example

Suppose that your latest version tag is `v1.2.3`, and you'd like to generate a new beta release. You only have to execute:
```sh
php artisan versioner:git:generate beta
```
After that a new tag `v1.3.0` must have been generated. Then, if you'd like to generate a new alpha release:
```sh
php artisan versioner:git:generate alpha
```
So now you have a new version `v1.3.1`. Then, if you'd like to generate the `v2.0.0` version:
```sh
php artisan versioner:git:generate release
```

### License

MIT
