# Laravel Database Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/infinitypaul/laravel-database-filter.svg?style=flat-square)](https://packagist.org/packages/infinitypaul/laravel-database-filter)
[![Build Status](https://img.shields.io/travis/infinitypaul/laravel-database-filter/master.svg?style=flat-square)](https://travis-ci.org/infinitypaul/laravel-database-filter)
[![Quality Score](https://img.shields.io/scrutinizer/g/infinitypaul/laravel-database-filter.svg?style=flat-square)](https://scrutinizer-ci.com/g/infinitypaul/laravel-database-filter)
[![Total Downloads](https://img.shields.io/packagist/dt/infinitypaul/laravel-database-filter.svg?style=flat-square)](https://packagist.org/packages/infinitypaul/laravel-database-filter)

Need to filter database results with a query string? Filter Laravel Model With Query Strings

## Installation

You can install the package via composer:

```bash
composer require infinitypaul/laravel-database-filter
```

The package will automatically register itself, but if your laravel versions is < 5.5 you will need to add Infinitypaul\LaravelDatabaseFilter\LaravelDatabaseFilterServiceProvider::class, service provider under your config/app.php file.

## Usage
Once the package is installed, an  artisan commands is available to you.

```bash
php artisan make:filter 
```

Generate a new model filter 
```bash
php artisan make:filter SchoolFilter --model
``` 
This will generate a new php file under app/Filters/ folder with the name SchoolFilter.php which will look like below.

``` php
<?php

namespace App\Filters;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FiltersAbstract;

class SchoolFilter extends FiltersAbstract {
        protected $filters = [];
}

```
Add The filterTrait and Register The SchoolFilter On Your Laravel Model Where The Filter Will Be User
```php


namespace App;

use App\Filters\SchoolFilter;
use Infinitypaul\LaravelDatabaseFilter\Traits\filterTrait;


class Course extends Model
{
    use filterTrait;

    protected $filter = SchoolFilter::class;

}
```
On the $filters variable in the SchoolFilter we can register all the conditions we are to filter against.


Let assume we want to filter our database by check those who have paid, then we need to create a new filter class by using the artisan command below

```bash
php artisan make:filter PaidFilter
``` 

This will also generate a new php file under app/Filters/ folder with the name PaidFilter.php which will look like below.

```php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FilterAbstract;

class PaidFilter extends FilterAbstract
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
Then we are register our conditions in the SchoolFilter We Created Above,

```php

namespace App\Filters;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FiltersAbstract;

class SchoolFilter extends FiltersAbstract {
        protected $filters = [
            'paid' => PaidFilter::class
        ];
}
```

The Filter Array Key is What we be shown as the query string as paid

```
    http://localhost:8080/education?paid=free
```

while the value PaidFilter::class takes us to the new class we created where we can write our conditions

```php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FilterAbstract;

class PaidFilter extends FilterAbstract
{
    
        public function mappings ()
        {
            return [];
        }

       
        public function filter(Builder $builder, $value)
        {
            return $builder->where('difficulty', $value);
        }
}

```

The Filter Method Takes In Our Condition or whatever we want to check against the database

In Case You Want To Be Strict About What A User Enters Into The Query Params You Can Use The Mapping Method

```php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FilterAbstract;

class PaidFilter extends FilterAbstract
{
    
        public function mappings ()
        {
            return [
                'free' => true,
                'premium' => false
            ];
        }

```

With The Above Config, You Can Only Accept free or paid from the user Into Your Paid Params And They Will Return Their Values Accordingly

Lastly You should be able to add the filter() scope to your model in your controller

```php
namespace App\Http\Controllers;

use App\Course;
use App\Filters\AccessFilter;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request){
        return Course::filter($request)->get();
    }
}
```
You Can Register As Many Filter You Want

```php
<?php

namespace App\Filters;

use Infinitypaul\LaravelDatabaseFilter\Abstracts\FiltersAbstract;

class SchoolFilter extends FiltersAbstract {
        protected $filters = [
            'paid' => PaidFilter::class,
            'access' => AccessFilter::class,
            'difficulty' => DifficultyFilter::class
        ];
}

```

With The Above Settings, Your Url Will End Up Like This

```
    http://localhost:8080/education?paid=free&access=whatever&difficulty=whoever
```

You can add custom filter to your controller, by passing an array of filter into the filter scope

```php
  public function index(Request $request){
        return Course::filter($request, ['score' => DifficultyFilter::class])->get();
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

