# Laravel Route Documentation
Maybe we are wondering where these routes lead or what could be their purpose?
This package decides to solve this solution.

The package provide us the `fix` thing, the `BlogBlock` improvement` for the route.

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
And then by executing `php artisan route:docs` the documentation is created.
