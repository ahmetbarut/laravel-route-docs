# Laravel Route Documentation

Maybe we are wondering where these routes lead or what could be their purpose?
This package decides to solve this solution.

The package allows us to easily retrieve documents using `docBlock` comments
way of working:

```php
    /**
    * @route-doc 
    * All comments written between these tags are collected and returned by the filter.
    * @end-doc    
    */
    Route::get('/home', function (){
        return 'Hello Docs'; 
    });
```

Usage inside the controller

```php
    Route::get('/home', 'HomeController@index');

    // HomeController.php
    /**
    * @route-doc 
    * All comments written between these tags are collected and returned by the filter.
    * @end-doc    
    */    
    public function index()
    {
        return 'Hello Docs !';    
    }
```

## Install

```shell
composer require ahmetbarut/laravel-route-docs
```

And then by executing `php artisan route:docs` the documentation is created.

## Arguments

This package currently only outputs markdown.
`path` is available, for this it should be written as `php artisan route:docs /path/to`.

## \!Tip

If no default directory is specified, it will look for the `docs' folder in the root directory and generate an error if it cannot find it.
