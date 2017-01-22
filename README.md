# Laravel Versioner

This tool allows to handle project versions in [Laravel](https://laravel.com/) and [Git](https://git-scm.com/).

The versions are generated in Git as tags with the format `vX.Y.Z`. When generating a new vesion, this tool gets the latest git version tag and increseases it, depending on the type of release you want to generate.

### Requirements

- PHP >= 5.6
- Laravel >= 5.0

### Instalation

First of all, you need to add the package to your `composer.json` file.
```sh
composer require diegoalvarez/laravel-versioner
```

Then you have to add a new provider in your config/app.php file, inside the **providers** list:
`Diegoalvarezb\Versioner\VersionerProvider::class`

### Show current version

To show the current version you have to execute the following command:
```sh
php artisan versioner:git:show
```

### Generate new version

To generate a new version you have to execute the artisan command `php artisan versioner:git:new` and insert the type of the release you'd like to generate. There are three realease options:
- **release**: increases the X
- **beta**: increases the Y
- **alpha**: increases the Z

The command will create a new tag from `master` branch, and push it to origin.

```sh
php artisan versioner:git:new
```

### License

MIT
