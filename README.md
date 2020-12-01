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
- after installation, package will auto-register the below to `composer.json`
    + check [composer docs](https://getcomposer.org/doc/articles/scripts.md#what-is-a-script-) for more info

    ```json
    "scripts": {
        "post-install-cmd": [
            "@php artisan pcl:post-install"
        ],
        "post-update-cmd": [
            "@php artisan pcl:post-update"
        ],
        "pre-package-uninstall": [
            "@php artisan pcl:pre-uninstall"
        ]
    }
    ```
    
<br>

## Upgrading to v:v:

- remove `'App\\Providers\\EventServiceProvider::postAutoloadDump'` from `composer.json`
- remove 
    ```
    /**
    * "ctf0/package-changelog".
    */
    public static function postAutoloadDump(\Composer\Script\Event $event)
    {
       if (class_exists('ctf0\PackageChangeLog\Ops')) {
           return \ctf0\PackageChangeLog\Ops::postAutoloadDump($event);
       }
    }
    ```
    from `app\Providers\EventServiceProvider`
- remove the package cache `storage/framework/cache/data/dd`

<br>

## Usage

- inside your **"package"** composer.json
    + add the package as a dependency
    + add `"changeLog": "log_folder_name"` to extra
    
    ```js
    "require": {
        // ...
        "ctf0/package-changelog": "^2.0"
    },
    "extra": {
        // ...
        "changeLog": "logs"
    }
    ```

- inside that folder add the log files
    - install `post-install-cmd`
    > if you want to show a log on installation only, then add a file name `install.txt` and we will display it only when the package gets installed for the first time.

    | release tag | log file name |
    | ----------- | ------------- |
    | *           | install.txt   |

    - uninstall `pre-package-uninstall`
    > if you want to show a log on un-installation only, then add a file name `uninstall.txt` and we will display it only when the package gets uninstalled.

    | release tag | log file name |
    | ----------- | ------------- |
    | *           | uninstall.txt |

    - update `post-update-cmd`
    > the version have to be equal "==" to the release tag because we check against that version b4 showing the log.
    >
    > this is useful in-case you didn't add a changeLog for the current published version.

    | release tag | log file name |
    | ----------- | ------------- |
    | v1.0.0      | v1.0.0.txt    |

<br>

## Notes

- we don't use any parser for the log file, so whatever you write in the file will be displayed to the user as it is.
- This is more of a **utility** package directed towards developers & to get the best of it you have to add it to your package, however to test it you can install it like any other package & you would get a message like the screenshot above.
