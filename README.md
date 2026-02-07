Simple Log
=========

[![Latest Stable Version](https://poser.pugx.org/bluetree-service/simple-log/v/stable.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/simple-log)
[![Total Downloads](https://poser.pugx.org/bluetree-service/simple-log/downloads.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/simple-log)
[![License](https://poser.pugx.org/bluetree-service/simple-log/license.svg?style=flat-square)](https://packagist.org/packages/bluetree-service/simple-log)

[![Build Status](https://travis-ci.org/bluetree-service/simple-log.svg?style=flat-square)](https://travis-ci.org/bluetree-service/simple-log)
[![Coverage Status](https://coveralls.io/repos/github/bluetree-service/simple-log/badge.svg?style=flat-square&branch=master)](https://coveralls.io/github/bluetree-service/simple-log?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bluetree-service/simple-log/badges/build.png?style=flat-square&b=master)](https://scrutinizer-ci.com/g/bluetree-service/simple-log/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/bluetree-service/simple-log/badges/coverage.png?style=flat-square&b=master)](https://scrutinizer-ci.com/g/bluetree-service/simple-log/?branch=master)

[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_simple-log&metric=bugs)](https://sonarcloud.io/summary/new_code?id=bluetree-service_simple-log)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_simple-log&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=bluetree-service_simple-log)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_simple-log&metric=coverage)](https://sonarcloud.io/summary/new_code?id=bluetree-service_simple-log)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_simple-log&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_simple-log)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_simple-log&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_simple-log)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_simple-log&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=bluetree-service_simple-log)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=bluetree-service_simple-log&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=bluetree-service_simple-log)

[![SonarQube Cloud](https://sonarcloud.io/images/project_badges/sonarcloud-dark.svg)](https://sonarcloud.io/summary/new_code?id=bluetree-service_simple-log)

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

### Usage PSR-3

Save simple log message into default log directory with level `error`:
```php
LogStatic::log('error', 'Some log message');
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

* PHP 8.2 or higher

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
