# CollectionPaginator Trait
Allows you to utilize the Eloquent\\Builder's paginate methods on regular Eloquent Collections.

## Why use this?
Out of the box, Laravel only provides pagination methods on the Eloquent builder. This can be limiting since sometimes you'll get the data before paginating, or use a method that does. Once this happens, you can't access the `paginate()` or `simplePaginate()` methods anymore.

If you're still dealing with a `Illuminate\Database\Eloquent\Collection`, then this trait will allow you to paginate the results!

## Requirements
* Laravel 5.4+

## How to use:
Open up your app's `AppServiceProvider`, then paste this line amongst your `use` imports:
```
use MallardDuck\LaravelTraits\Eloquent\CollectionPaginator;
```

Near the top of your `AppServiceProvider` class, paste:
```php
use CollectionPaginator;
```

Now, within the `boot()` method add:
```php
$this->bootCollectionPaginator();
```

And that's it!

The next time you're working with an Eloquent\\Collection you can now simply use the `paginate()` or `simplePaginate` like you would with the builder!
