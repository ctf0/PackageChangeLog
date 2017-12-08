# PackageChangeLog

[![Latest Stable Version](https://img.shields.io/packagist/v/ctf0/package-changelog.svg)](https://packagist.org/packages/ctf0/package-changelog) [![Total Downloads](https://img.shields.io/packagist/dt/ctf0/package-changelog.svg)](https://packagist.org/packages/ctf0/package-changelog)
[![Donate with Bitcoin](https://en.cryptobadges.io/badge/micro/16ri7Hh848bw7vxbEevKHFuHXLmsV8Vc9L)](https://en.cryptobadges.io/donate/16ri7Hh848bw7vxbEevKHFuHXLmsV8Vc9L)

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

- after installation, package will auto-register
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
      "ctf0/package-changelog": "^1.0"
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