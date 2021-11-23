Simple Log
=========

[![Latest Stable Version](https://poser.pugx.org/bluetree-service/simple-log/v/stable.svg)](https://packagist.org/packages/bluetree-service/simple-log)
[![Total Downloads](https://poser.pugx.org/bluetree-service/simple-log/downloads.svg)](https://packagist.org/packages/bluetree-service/simple-log)
[![License](https://poser.pugx.org/bluetree-service/simple-log/license.svg)](https://packagist.org/packages/bluetree-service/simple-log)

##### Builds
| Travis | Scrutinizer |
|:---:|:---:|
| [![Build Status](https://app.travis-ci.com/bluetree-service/simple-log.svg?branch=master)](https://app.travis-ci.com/github/bluetree-service/simple-log) | [![Build Status](https://scrutinizer-ci.com/g/bluetree-service/simple-log/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bluetree-service/simple-log/build-status/master) |

##### Coverage
| Coveralls | Scrutinizer |
|:---:|:---:|
| [![Coverage Status](https://coveralls.io/repos/github/bluetree-service/simple-log/badge.svg?branch=master)](https://coveralls.io/github/bluetree-service/simple-log?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/bluetree-service/simple-log/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bluetree-service/simple-log/?branch=master) |

##### Quality
| Code Climate | Scrutinizer | SymfonyInsight |
|:---:|:---:|:---:|
| [![Code Climate](https://codeclimate.com/github/bluetree-service/simple-log/badges/gpa.svg)](https://codeclimate.com/github/bluetree-service/simple-log) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bluetree-service/simple-log/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bluetree-service/simple-log/?branch=master) | [![SymfonyInsight](https://insight.symfony.com/projects/32a9a415-754b-497d-b345-320381fbdc20/mini.svg)](https://insight.symfony.com/projects/32a9a415-754b-497d-b345-320381fbdc20) |
|  | [![Code Intelligence Status](https://scrutinizer-ci.com/g/bluetree-service/simple-log/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence) |  |

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

* PHP 7.1 or higher

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
