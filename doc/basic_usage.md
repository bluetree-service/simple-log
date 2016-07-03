# Basic usage
The simplest way to use simple log is create log message by static interface.

```php
LogStatic::makeLog('Some log message');
```

As message you can give array that will be changed into key->val string. Array can be nested, there are no limit for
such nested array.

LogStatic is called as **singleton**

------------------------

There also exist possibility to create log object instance.

```php
(new Log)->makeLog('Some log message');
```

## Configuration

Available configuration options:

* **log_path** - path to save log file
* **type** - log type (default ins notice)

### Static configuration

* **setOption($key, $val)** - set specified option value
* **getOption($key)** - get value of key option, or all options if `$key` is `null`

There also exist possibility to give some specified options for one log message. To do that we can add options array as
second `makeLog` method parameter.

```php
LogStatic::makeLog(
    'Some log message',
    [
        'log_path' => '/var/log/simple-log'
    ]
);
```

### Object instance configuration
First we must create Log object instance.

* **setOption($key, $val)** - set specified option value
* **getOption($key)** - get value of key option, or all options if `$key` is `null`

There also exist possibility to give some specified options for one log message. To do that we can add options array as
second `makeLog` method parameter.

```php
(new Log)->makeLog(
    'Some log message',
    [
        'log_path' => '/var/log/simple-log'
    ]
);
```

## Message examples

Simple message:
```
28-06-2016 - 09:39:09
Some log message
-----------------------------------------------------------
```

Array message:  
```
28-06-2016 - 09:39:09
- event_name: test_event
- listener: ClassEvent\Test\EventDispatcherTest::trigger
- status: ok
-----------------------------------------------------------
```

Nested array message:
```
28-06-2016 - 09:39:09
- event_name: test_event
- listener: ClassEvent\Test\EventDispatcherTest::trigger
- sub array:
    - key: val
    - key 2: val 2
-----------------------------------------------------------
```
