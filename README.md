# Laravel Versioner

This tool handle project versions in [Laravel](https://laravel.com/) and [Git](https://git-scm.com/).

The versions are generated in Git as tags with the format `vX.Y.Z`. When generating a new version, this tool gets the latest git version tag and increseases it, depending on the type of release you want to generate.

### Requirements

- PHP >= 5.6
- Laravel >= 5.0

### Installation and configuration

Package installation with composer:
```
composer require diegoalvarezb/laravel-versioner
```

And add the service provider in your `config/app.php` file:
```php
Diegoalvarezb\Versioner\VersionerProvider::class
```

The service provider will register the package commands, so you can use them with artisan.

### Show current version

To show the current version you have to execute the following command:
```sh
php artisan versioner:git:show
```

### Generate new version

To generate a new version you have to execute the artisan command `php artisan versioner:git:new` and then select the type of the release you'd like to generate. There are three realease options:
- **MAJOR**: increases the X
- **MINOR**: increases the Y
- **PATCH**: increases the Z

The command will create a new tag from `master` branch, and push it to origin.

```sh
php artisan versioner:git:new
```

### License

MIT
