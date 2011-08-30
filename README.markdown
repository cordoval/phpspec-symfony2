PHPSpec Symfony2
================

What it PHPSpec_Symfony2
------------------------

**PHPSpec_Symfony2** is an extension of PHPSpec to perform BDD in Symfony2 Framework
applications.

Setup
-----
On deps file insert the follow friend entries:

```ini
[PHPSpec]
    git=https://github.com/phpspec/phpspec.git
    target=/phpspec

[PHPAutotest]
    git=https://github.com/Programania/PHPAutotest.git
    target=/PHPAutotest

[phpspec-symfony2]
    git=https://github.com/cordoval/phpspec-symfony2.git
    target=/phpspec-symfony2

[mockery]
    git=https://github.com/padraic/mockery.git
    target=/mockery

[hamcrest-php]
    git=https://github.com/cordoval/hamcrest-php.git
    target=/hamcrest-php
```

Usage
-----

here goes how it is used in classes