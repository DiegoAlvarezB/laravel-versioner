# Laravel Versioner
----

This tool allows to handle project versions in [Laravel](https://laravel.com/) and [Git](https://git-scm.com/).

The versions are generated as tags in Git, with the format `vX.Y.Z`. To generate a new vesion this tool gets the last git version tag and increseases it, depending on the type of release you want to generate.


### Requirements

- PHP >= 5.6
- Laravel >= 5.0


### Instalation

You only need to add the package to your `composer.json` file.
```sh
composer require xxxxxxx
```


### Command

To generate a new version you have to execute the artisan command `php artisan versioner:git:generate` passing the type of release you want to generate. There are three options:
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

Suppose that your last version tag is `v1.2.3`, and you want to genrate a new beta release. You have to execute:
```sh
php artisan versioner:git:generate beta
```
After that a new tag `v1.3.0` must have been generated. Then, you want to generate an alpha release.
```sh
php artisan versioner:git:generate alpha
```
So now you have a new version `v1.3.1`. And then...
```sh
php artisan versioner:git:generate release
```
That will generate `v2.0.0`

### License

MIT
