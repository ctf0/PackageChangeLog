<p align="center">
    <img src="demo.png">
</p>

### Intro

usually when a package gets updated, the package owner could possibly add/change/remove something from the configuration file,
or could add a new feature that he/she didn't have time to add to the readme yet,
or for whatever reason that could potentially effect how the user consume the package.

Therefor **PackageChangeLog** was made, to help developers keep their packages as user friendly as possible and keep the users up-to-date with new changes as releases gets published.

# Installation

- `composer require ctf0/package-changelog`

- (Laravel < 5.5) add the service provider to `config/app.php`

```php
'providers' => [
    ctf0\PackageChangeLog\PackageChangeLogServiceProvider::class,
]
```

- after installation, package will auto-register
  + `App\\Providers\\EventServiceProvider::postAutoloadDump` @composer.json `post-autoload-dump`
  + `postAutoloadDump` method @ `App\Providers\EventServiceProvider`

- **Note** that logs will be shown from the next time composer gets executed.

## Usage

- add `"changeLog": "log_folder_name"` to your **"package"** composer.json, ex.`logs`

```js
"extra": {
  // ...

  "changeLog": "logs"
},
```

- inside that folder add the log files
> note that the version have to be equal "==" to the release tag because we check against that version b4 showing the log.
>
> this is useful in-case you don't/didn't add changeLogs for the current published version.

   | release tag | log file name |
   |-------------|---------------|
   | v1.0.0      | v1.0.0.txt    |

- we don't use any parsers for the log file, so whatever you write in the file, will be displayed the user as it is.
