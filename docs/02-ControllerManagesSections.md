# ControllerManagesSections Trait
Easily set Blade directive sections from within a Controller.

## Why use this?
Do you use Blade as your main templating system?
Ever wanted to define the value of a section outside of your `.blade.php` file?
Want to have an easier method to setup page/controller specific meta data?

When using Blade as your main templating system it's common to have a section for setting the page's Title attribute. Or, maybe you're managing the pages `robots` meta-tag, body class, or similar. It's easy enough to do directly in the blade files, but in some cases this may not feel ideal.

What if instead of this, in your view:
```php
@php
  $safeName = safeTitleToClass($item->label);
@endphp

@section('title', 'Blog Page')
@section('robots', 'index,follow')
@section('body-class', 'item-page item-' . $safePage)
```

You could do this, in you controller:
```php
# In your constructor
$this->bladeSections = [
  'title'      => 'Blog Page',
  'robots'     => 'index,follow',
  'body-class' => 'item-page item-' . safeTitleToClass($item->label),
];
$this->bootManagesSections();
```

## Requirements
* Laravel 5+
* Using the `Illuminate\Contracts\View\Factory` directly, instead of facades or magic methods
Specifically, you should inject this in the constrctor and set it to `$this->viewFactory`.

## How to use:
First things first, pick the controller you want to manage Blade sections within and open it up. You can do this to individual controllers, or the App's base controller.

Then ensure that the Controller has `Illuminate\Contracts\View\Factory` assigned to `$this->viewFactory`.

Now, paste this line amongst your `use` imports:
```
use MallardDuck\LaravelTraits\Http\ControllerManagesSections;
```

Near the top of your Controller class, paste:
```php
use ControllerManagesSections;
```

Within the commands `__construct` set the prefix:
```php
$this->bladeSections = [
  'robots'     => 'index,follow',
  'body-class' => 'item-page',
];
$this->bootManagesSections();
```
Where the item key is the section name and the value is the section content. In this case, we're setting the `robots` and `body-class` sections content.
And that's it!

### Setting dynamic values
Use this method if the content you want to set for the section changes based on controller data. For example, if you have a generic `PagesController` to CRUD frontend pages, then maybe you want the `title` section to be set by the current page.

First, set everything up as per noraml using the directions above. Essentially you need to make sure the trait is applied to the Controller, then include the `$this->bootManagesSections()` in the constructor.

Then you can set new bladeSections within the controller method. The only catch is that you'll manually need to call the `setControllerSections()` method - which is automatically called by `bootManagesSections()`.

Using an invokable controller as an example, you would then modify the `_invoke` method. In the end, you class should look something like this:

```php
public function __construct(Factory $viewFactory)
{
    $this->bladeSections = [
      'robots'     => 'index,follow',
      'body-class' => 'page-page',
    ];
    parent::__construct($viewFactory);
}

public function __invoke(Page $page)
{
    if (!$page->active) {
      throw new NotFoundHttpException('Page with that slug does not exist.');
    }

    $this->bladeSections['title']      = $page->label . ' Page';
    $this->bladeSections['body-class'] .= ' page-' . safeTitleToClass($page->label);
    $this->setControllerSections(); // Call directly to apply the sections we just set

    return $this->viewFactory->make('page', compact('page'));
}
```
