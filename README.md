# Laravel Module Installer

Improved version of [joshbrw/laravel-module-installer](https://github.com/joshbrw/laravel-module-installer).

The purpose of this package is to allow for easy installation of standalone modules into the [Laravel Modules](https://github.com/nWidart/laravel-modules) package. This package will ensure that your module is installed into the `Modules/` directory instead of `vendor/`.

You can specify an alternate directory by including a `module-dir` in the extra data in your composer.json file:

    "extra": {
        "module-dir": "Custom"
    }


## Installation

    composer require brnbio/laravel-module-installer

## Usage

Ensure you have the `type` set to `laravel-module` in your module's `composer.json`

    {
        "name": "vendor/name",
        "type": "laravel-module",
    }

    // install dir: /Modules/name

If the name contains a `-module`, this is removed.

    {
        "name": "vendor/name-module",
        "type": "laravel-module",
    }

    // install dir: /Modules/name
