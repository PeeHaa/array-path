# array-path

[![Code Coverage](https://scrutinizer-ci.com/g/PeeHaa/array-path/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PeeHaa/array-path/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/PeeHaa/array-path/badges/build.png?b=master)](https://scrutinizer-ci.com/g/PeeHaa/array-path/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PeeHaa/array-path/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PeeHaa/array-path/?branch=master)

Yet another array path implementation

## Requirements

- PHP 7.1+

## Usage

### ``get()``

    echo (new \PeeHaa\ArrayPath\ArrayPath())->get(['foo' => ['bar' => 'baz']], 'foo.bar'); // baz
    
    echo (new \PeeHaa\ArrayPath\ArrayPath())->get(['foo' => ['bar' => 'baz']], 'foo.qux'); // throws \PeeHaa\ArrayPath\NotFoundException

### ``exists()``

    echo (new \PeeHaa\ArrayPath\ArrayPath())->exists(['foo' => ['bar' => 'baz']], 'foo.bar'); // true
    
    echo (new \PeeHaa\ArrayPath\ArrayPath())->exists(['foo' => ['bar' => 'baz']], 'foo.qux'); // false

### ``set()``

    $array = [];
    (new \PeeHaa\ArrayPath\ArrayPath())->set($array, 'foo.bar', 'value');
    
    var_dump($array);
    
    /**
    array(1) {
      ["foo"]=>
      array(1) {
        ["bar"]=>
        string(5) "value"
      }
    }
    */

### ``remove()``

    $array = ['foo' => ['bar' => 'value']];
    (new \PeeHaa\ArrayPath\ArrayPath())->remove($array, 'foo.bar');
    
    var_dump($array);
    
    /**
    array(1) {
      ["foo"]=>
      array(0) {
      }
    }
    */

*Note: ``remove()`` will not throw when the key does not exist in the array.*
