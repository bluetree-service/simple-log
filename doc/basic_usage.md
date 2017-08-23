# Basic usage
The simplest way to use simple log is create log message by static interface.

```php
LogStatic::makeLog('Some log message');
```

That will generate bellow log structure:

```
28-06-2016 - 09:39:09
Some log message
-----------------------------------------------------------
```

As message you can give array that will be changed into key->val string. Array can be nested, there are no limit for
such nested array.

LogStatic is called as **singleton**

Because of implementation of [PSR-3](http://www.php-fig.org/psr/psr-3/) there also appear `log` method compatible with PSR.

```php
LogStatic::log('notice', 'Some log message');
```

On static usage there is no other PSR-3 methods available (emergency, alert ...).

------------------------

There also exist possibility to create log object instance.

```php
(new Log)->makeLog('Some log message');
```

and use all methods available for PSR-3.

```php
$log = new Log;

$log->log('notice', 'Some message');
$log->warning('Some message');
$log->error('Some message');
```

## Configuration

Available configuration options used by constructor:

* **log_path** - path to save log file
* **level** - log level (default ins notice)
* **storage** - class that will be used for store log info (default `\SimpleLog\Storage\File`)

### Static configuration

* **setOption($key, $val)** - set specified option value
* **getOption($key)** - get value of key option, or all options if `$key` is `null`

There also exist possibility to give some specified options for one log message. To do that we can add options array as
third `makeLog` method parameter, or fourth parameter for `log` method.

```php
LogStatic::makeLog(
    'Some log message',
    [], //context array
    [
        'log_path' => '/var/log/simple-log'
    ]
);
```

### Object instance configuration
First we must create Log object instance.

* **setOption($key, $val)** - set specified option value
* **getOption($key)** - get value of key option, or all options if `$key` is `null`

## Message Building
Message given for log mostly are a simple string, or object with `__toString` method.
But PSR-3 allow to use a context to make messages more elastic and `SimpleLog` provide
to give array as message to build some more advanced structures.

### Array messages
`SimpleLog` allow to create more advanced log structures by using nested arrays.  
Usage is very simple, instead string message use nested array nad recurrent function
will build up special log structure looking similar to `yaml`.

```php
$message = [
    'event_name' => 'test_event,
    'listener' => 'ClassEvent\Test\EventDispatcherTest::trigger,
    'sub array' => [
        'key' => 'val',
        'key 2' => 'val 2',
    ],
];
LogStatic::makeLog($message);
```

That will generate bellow structure:

```
28-06-2016 - 09:39:09
- event_name: test_event
- listener: ClassEvent\Test\EventDispatcherTest::trigger
- sub array:
    - key: val
    - key 2: val 2
-----------------------------------------------------------
```

Here is example of array message without nested arrays:  
```
28-06-2016 - 09:39:09
- event_name: test_event
- listener: ClassEvent\Test\EventDispatcherTest::trigger
- status: ok
-----------------------------------------------------------
```

### Context usage
Because of PSR-3 usage, `SimpleLog` allow to usage context messages and build log template system.  
Usage is very simple, in log template add key that can be replaces by using brackets (_{key})
and paste for log method array of key=>val where key will be name of string to replace
and val will be message that appear in log message.  

```php
LogStatic::makeLog('Some log {key}', ['key' => 'message']);
LogStatic::log('notice', 'Some log {key}', ['key' => 'message']);
```
