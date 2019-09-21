<h1 align="center">
    PackageChangeLog
    <br>
    <a href="https://packagist.org/packages/ctf0/package-changelog"><img src="https://img.shields.io/packagist/v/ctf0/package-changelog.svg" alt="Latest Stable Version" /></a> <a href="https://packagist.org/packages/ctf0/package-changelog"><img src="https://img.shields.io/packagist/dt/ctf0/package-changelog.svg" alt="Total Downloads" /></a>
</h1>

usually when a package gets updated, the package owner could possibly add/change/remove something from the configuration file,
or could add a new feature that he/she didn't have time to add to the read me yet,
or for whatever reason that could potentially effect how the user consume the package.

Therefor **PackageChangeLog** was made, to help developers keep their packages as user friendly as possible and keep the users up-to-date with new changes as releases gets published.

<p align="center">
    <img src="https://user-images.githubusercontent.com/7388088/30776152-e2be70d6-a0a1-11e7-9793-0584a5ecb9f8.png">
</p>

## Installation

- `composer require ctf0/package-changelog`

- (Laravel < 5.5) add the service provider to `config/app.php`

    ```php
    'providers' => [
        ctf0\PackageChangeLog\PackageChangeLogServiceProvider::class,
    ]
    ```

- after installation, package will auto-register ["Why we need that ?"](https://getcomposer.org/doc/articles/scripts.md#what-is-a-script-)
    + `App\\Providers\\EventServiceProvider::postAutoloadDump` @**composer.json**
    + `postAutoloadDump`  @**App\Providers\EventServiceProvider**

<br>

## Usage

- inside your **"package"** composer.json
    + add the package as a dependency
    + add `"changeLog": "log_folder_name"` to extra

    ```js
    "require": {
        // ...
        "ctf0/package-changelog": "*"
    },
    "extra": {
        // ...
        "changeLog": "logs"
    }
    ```

- inside that folder add the log files

    > the version have to be equal "==" to the release tag because we check against that version b4 showing the log.
    > this is useful in-case you didn't add a changeLog for the current published version.

    | release tag | log file name |
    |-------------|---------------|
    | v1.0.0      | v1.0.0.txt    |

<br>

## Notes

- we don't use any parser for the log file, so whatever you write in the file will be displayed to the user as it is.

- This is more of a **utility** package directed towards developers & to get the best of it you have to add it to your package, however to test it you can install it like any other package & run `composer dump-autoload` afterwards.
