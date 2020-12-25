# SuperLayer php

#### Table of content

- [What is?](#what-is)
- [Configure child class](#cofigure-child-class)
- [Defined methods](#defined-methods)
- [Demo](#demo)

## What is?

SuperLayer is a pattern that allows to create diferent methods in the parent class, 
so that the child class may inherit these methods. In this pattern `superLayer` we 
define the deferent methods you might use to manage your DataBase.

----

## cofigure child-class

```php
    <?php 
    require_once "superLayer.php";
    require_once "conexion.php";
    
    class MyObject extends superLayer {
        function __construct()
        {
            $this->table = "";//set the table name
            $this->db = new Database; //initial the connection
            
            // *optional default true
            // if set to false it will hide all errors
            $this->showError = false;
        }
    }
```
### Defined methods
**getAll()**
```php
    //example 1
    $myObject->getAll();
    
    //example 2
    // select the columns to be fetched
    $myObject->getAll( ["name", "id"] );
```
**getOne()**
```php
    //example 1
    $myObject->getOne();
    
    //example 2
    // select the columns to be fetched
    $myObject->getOne( ["name", "id"] );
```
**update()**
```php
    // example
    // parameter must be an array key/value
    // the table id must be in the first position
    $myObject->update([
        "id" => 1528965,
        "email" => "example@host.com"
    ]);
```
**delete()**
```php
    // example
    // parameter mus be an Array and must contain
    // the identifier and its value
    $myObject->delete([
        "id" => 186
    ]);
```

**add()**
```php
    //example 
    // parameter mus be an Array (key/value) and must contain
    // the values to be saved
    $myObject->add([
        "name" => "your name",
        "email" => "email@host.com"
    ]);
```
----

## Demo
To run this demo just clone the repository and turn the php server on. open the index
file that is inside the demo folder.
