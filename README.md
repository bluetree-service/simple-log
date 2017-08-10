Simple Log
=========

[![Build Status](https://travis-ci.org/bluetree-service/simple-log.svg)](https://travis-ci.org/bluetree-service/simple-log)
[![Latest Stable Version](https://poser.pugx.org/bluetree-service/simple-log/v/stable.svg)](https://packagist.org/packages/bluetree-service/simple-log)
[![Total Downloads](https://poser.pugx.org/bluetree-service/simple-log/downloads.svg)](https://packagist.org/packages/bluetree-service/simple-log)
[![License](https://poser.pugx.org/bluetree-service/simple-log/license.svg)](https://packagist.org/packages/bluetree-service/simple-log)
[![Coverage Status](https://coveralls.io/repos/github/bluetree-service/simple-log/badge.svg?branch=master)](https://coveralls.io/github/bluetree-service/simple-log?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b924032d-b6be-4500-bbd7-2292a61d541d/mini.png)](https://insight.sensiolabs.com/projects/b924032d-b6be-4500-bbd7-2292a61d541d)
[![Code Climate](https://codeclimate.com/github/bluetree-service/simple-log/badges/gpa.svg)](https://codeclimate.com/github/bluetree-service/simple-log)

Simply way to create log message written directly into file.

## Usage

Save simple log message into default log directory:
```php
LogStatic::makeLog('Some log message');
```

To set different log directory use that command:
```php
LogStatic::setOption('log_path', '/var/log/simple-log');
```

---------------

More information in:  
[Change log](https://github.com/bluetree-service/simple-log/doc/basic_usage.md "Change log")

Install via Composer
--------------
To use packages you can just download package and pace it in your code.

```json
{
    "require": {
        "bluetree-service/simple-log": "version_number"
    }
}
```

Project description
--------------

### Used conventions

* **Namespaces** - each library use namespaces
* **PSR-2** - [PSR-2](http://www.php-fig.org/psr/psr-2/) Coding Style
* **PSR-3** - [PSR-3](http://www.php-fig.org/psr/psr-3/) Logger Interface
* **PSR-4** - [PSR-4](http://www.php-fig.org/psr/psr-4/) Autoloading Standard
* **Composer** - [Composer](https://getcomposer.org/) usage to load/update libraries

### Requirements

* PHP 5.5 or higher

Change log
--------------
All release version changes:  
[Change log](https://github.com/bluetree-service/simple-log/doc/change_log.md "Change log")

License
--------------
This bundle is released under the Apache license.  
[Apache license](https://github.com/bluetree-service/simple-log/LICENSE "Apache license")

Travis Information
--------------
[Travis CI Build Info](https://travis-ci.org/bluetree-service/simple-log)
