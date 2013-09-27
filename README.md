TmsFormGeneratorBundle
======================

Symfony2 bundle used to generate a Form from an array

Installation
------------

The installation is a quick 3 steps process!

### Step 1: Composer

First, add these dependencies in your `composer.json` file:

```json
"repositories": [
    ...,
    {
        "type": "vcs",
        "url": "https://github.com/Tessi-Tms/TmsFormGeneratorBundle.git"
    }
],
"require": {
        ...,
        "tms/form-generator-bundle": "dev-master"
    },
```

Then, retrieve the bundles with the command:

```sh
composer update      # WIN
composer.phar update # LINUX
```

### Step 3: Kernel

Enable the bundles in your application kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tms\Bundle\OperationClientBundle\TmsFormGeneratorBundle(),
    );
}
`

Documentation
-------------

You can do a lot more than that! Check the full [documentation](https://github.com/Tessi-Tms/TmsFormGeneratorBundle/blob/master/Resources/doc/index.md)!``