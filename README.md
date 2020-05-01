# Laravel Database Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/infinitypaul/laravel-database-filter.svg?style=flat-square)](https://packagist.org/packages/infinitypaul/laravel-database-filter)
[![Build Status](https://img.shields.io/travis/infinitypaul/laravel-database-filter/master.svg?style=flat-square)](https://travis-ci.org/infinitypaul/laravel-database-filter)
[![Quality Score](https://img.shields.io/scrutinizer/g/infinitypaul/laravel-database-filter.svg?style=flat-square)](https://scrutinizer-ci.com/g/infinitypaul/laravel-database-filter)
[![Total Downloads](https://img.shields.io/packagist/dt/infinitypaul/laravel-database-filter.svg?style=flat-square)](https://packagist.org/packages/infinitypaul/laravel-database-filter)

  Ever been stuck with filtering a database table with lots of GET parameters?  I can only imagine how bulky your code will be. Relax, the easiest solution to this problem is right here.     Let's say we have to query our records table with the following get parameters
  
  >https://www.example.com/records?dept=csc&level=200&grade=A
  
  

## Installation

You can install the package via composer:

```bash
composer require infinitypaul/laravel-database-filter
```

The package will automatically register itself, but if your laravel versions is < 5.5 you will need to add Infinitypaul\LaravelDatabaseFilter\LaravelDatabaseFilterServiceProvider::class, service provider under your config/app.php file.

## Usage
Once the package is installed, an artisan command is available to you.

```bash
php artisan make:filter 
```
We would be working with the records table below:

| Id  | Department | Level | Score | Grade|
| --- | -----------| ------| ------| -----|
| 1   | csc        | 200  | 68    | b     |
| 2   | physics    | 100  | 90    | a     |
| 3   | csc        | 100  | 90    | a     |
| 4   | physics    | 200  | 60    | b     |
| 5   | csc        | 200  | 80    | a     |

 The Filtering be done in 6 simple steps. Perfect right! Let's begin:

### * Step 1

Create a mother filter class, this is where all filters will be recorded. This can be created with this one line of code: 

```bash
php artisan make:filter RecordFilter --model
``` 
 This package will generate a new PHP file RecordFilter.php under app/Filters folder. This is where all other filters will be created.. It wil look like this

``` php
<?php

namespace App\Filters;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FiltersAbstract;

class RecordFilter extends FiltersAbstract {
        protected $filters = [];
}

```
### * Step 2:

Since we are working with the records table, we will be working on the Record model. So open your Record model and include the following:
    * The Filter Trait
    * The Record Filter Class

```php


namespace App;

use App\Filters\RecordFilter;
use Infinitypaul\LaravelDatabaseFilter\Traits\filterTrait;


class Course extends Model
{
    use filterTrait;

    protected $filter = RecordFilter::class; //mother filter class

}
```

### * Step 3:

We would be filtering with 3 parameters (dept, level, grade):

Let's create filter classes for each filter

```bash
php artisan make:filter DeptFilter
php artisan make:filter LevelFilter
php artisan make:filter GradeFilter
``` 

The above commands will also generate a new PHP file under app/Filters folder with the name DebtFilter.php, LevelFilter.php and GradeFilter.php which will look like below.

```php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FilterAbstract;

class DebtFilter extends FilterAbstract
{
    
        public function mappings ()
        {
            return [];
        }

        
        public function filter(Builder $builder, $value)
        {
            return $builder;
        }
}


```

 Well Done!!! Let's move to the next step
 
### * Step 4:

Now we write our logic in each class:

In our DeptFilter class, we write the following:

```php

  namespace App\Filters;

            use Illuminate\Database\Eloquent\Builder;

            use Infinitypaul\LaravelDatabaseFilter\Abstracts\FilterAbstract;

            class DeptFilter extends FilterAbstract
            {

                    public function mappings ()
                    {
                        return [];
                    }

                    public function filter(Builder $builder, $value)
                    {
                        return $builder->where('dept', $value);
                    }
            }
```

In our LevelFilter class, we write the following:

```php

            namespace App\Filters;

            use Illuminate\Database\Eloquent\Builder;

            use Infinitypaul\LaravelDatabaseFilter\Abstracts\FilterAbstract;

            class LevelFilter extends FilterAbstract
            {

                    public function mappings ()
                    {
                        return [];
                    }

                    public function filter(Builder $builder, $value)
                    {
                        return $builder->where('level', $value);
                    }
            }

```

In our GradeFilter class, we write the following:

```php

            namespace App\Filters;

            use Illuminate\Database\Eloquent\Builder;

            use Infinitypaul\LaravelDatabaseFilter\Abstracts\FilterAbstract;

            class GradeFilter extends FilterAbstract
            {

                    public function mappings ()
                    {
                        return [];
                    }

                    public function filter(Builder $builder, $value)
                    {
                        return $builder->where('grade', $value);
                    }
            }

```

The filter method takes in our conditions or whatever  checks against the database

 Bravo on completing that. Moving on!!!
 
 
### * Step 5:
 
 We write our search parameters against the filter class. Let's open up our mother filter class - RecordFilter to register all the conditions we have generated. 
 
 ```php
 
             namespace App\Filters;
 
             use Infinitypaul\LaravelDatabaseFilter\Abstracts\FiltersAbstract;
 
             class RecordFilter extends FiltersAbstract {
                     protected $filters = [
                         'dept' => DeptFilter::class,
                         'level' => LevelFilter::class,
                         'grade' => GradeFilter::class
                     ];
             }
 
 ```

The $Filter array key is will be the query params.

### * Step 6:

Assuming we have a controller RecordController, we can create a function to get our record:

```php

namespace App\Http\Controllers;

use App\Course;
use App\Filters\AccessFilter;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index(Request $request){
        return Record::filter($request)->get();
    }
}

```

We are all done!!!

When we enter the following into our browser

> https://www.example.com/records?dept=csc&level=200&grade=a

We will get the following result:

```

            {
                "data": [
                    {
                        "id": 5,
                        "department": "csc",
                        "level": 200,
                        "score": "80",
                        "grade": "a"
                    }
                ]
            }

```
### Tweak Time

To be strict about query params input, we can use the mapping method or leave empty for free entry.

Let's say when returning the data, we want all department with csc to return as CSC. We return values to the mappings function in the DeptFilter class as shown below:

```php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FilterAbstract;

class DeptFilter extends FilterAbstract
{
    
        public function mappings ()
        {
            return [
                'csc' => 'CSC'
            ];
        }

public function filter(Builder $builder, $value)
                    {
                        return $builder->where('dept', $value);
                    }

```

With the above setup, once csc is entered in your query params, it will return CSC as value.

Lastly, You can add local scoped filter() by passing an array of filter into the filter scope.


```php
  public function index(Request $request){
        return Record::filter($request, ['score' => DifficultyFilter::class])->get();
    }
```



### Bug & Features

If you have spotted any bugs, or would like to request additional features from the library, please file an issue via the Issue Tracker on the project's Github page: [https://github.com/infinitypaul/laravel-database-filter/issues](https://github.com/infinitypaul/laravel-database-filter/issues).

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email infinitypaul@live.com instead of using the issue tracker.

## How can I thank you?

Why not star the github repo? I'd love the attention! Why not share the link for this repository on Twitter or HackerNews? Spread the word!

Don't forget to [follow me on twitter](https://twitter.com/infinitypaul)!

Thanks!
Edward Paul.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

