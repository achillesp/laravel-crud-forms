# Laravel CRUD Forms

[![Latest Version on Packagist](https://img.shields.io/packagist/v/achillesp/laravel-crud-forms.svg)](https://packagist.org/packages/achillesp/laravel-crud-forms)
[![run-tests](https://github.com/achillesp/laravel-crud-forms/actions/workflows/run-tests.yml/badge.svg)](https://github.com/achillesp/laravel-crud-forms/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/achillesp/laravel-crud-forms.svg)](https://packagist.org/packages/achillesp/laravel-crud-forms)
[![License](https://img.shields.io/packagist/l/achillesp/laravel-crud-forms.svg)](LICENSE.md)

Scaffold a complete CRUD (Create, Read, Update, Delete) interface for an Eloquent
model — an index listing plus create/show/edit forms with validation and soft-delete
support — by adding **one trait** to a resource controller. No generators and no
reactive front-end: just a trait and a set of publishable, server-rendered Blade views
(Bootstrap or Tailwind) that stay out of the way of the rest of your app.
This aims to be used as a quick tool which does not interfere with the other parts of the application that it's used in.

```php
use App\Models\Post;
use Achillesp\CrudForms\CrudForms;

class PostController extends Controller
{
    use CrudForms;

    public function __construct(Post $post)
    {
        $this->model = $post;

        $this->formFields = [
            ['name' => 'title',       'label' => 'Title',    'type' => 'text'],
            ['name' => 'body',        'label' => 'Body',     'type' => 'textarea'],
            ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        ];
    }
}
```

```php
// routes/web.php
Route::resource('posts', PostController::class);
```

That gives you a working CRUD UI for the `Post` model. See [Usage](#usage) for every
available option, and [Views and themes](#views-and-themes) for styling.

## Compatibility

The latest release supports **Laravel 11, 12 and 13** on **PHP 8.2+** (PHP 8.3+ for
Laravel 13). Composer installs the right version for your app automatically:

```
composer require achillesp/laravel-crud-forms
```

Older Laravel versions are covered by earlier major releases:

| Laravel        | Package version   |
|---------------:|-------------------|
| 11, 12, 13     | `^9.0` (latest)   |
| 10             | `^6.0`            |
| 9              | `^5.0`            |
| 8              | `^4.0`            |
| 7              | `^3.0`            |
| 6              | `^2.0`            |

## Installation

### Composer

From the command line, run:

```
composer require achillesp/laravel-crud-forms
```
 
### Configuration

This package uses a config file which you can override by publishing it to your app's config dir.

```
php artisan vendor:publish --provider="Achillesp\CrudForms\CrudFormsServiceProvider" --tag=config
``` 

## Usage

To use the package, you need to use the trait `Achillesp\CrudForms\CrudForms` in your model's controller and define your routes.
The trait provides all the required methods for a Resource Controller, as well as a restore method in case of soft-deleted models.

### Routes

If for example you have a `Post` model, you would define the route:

```php
use App\Http\Controllers\PostController;

Route::resource('posts', PostController::class);
```

### Controller

Then in your `PostController`, you will need to use the trait and also define a constructor where you give the needed details of the model.

```php
use App\Models\Post;
use Achillesp\CrudForms\CrudForms;

class PostController extends Controller
{
    use CrudForms;

    public function __construct(Post $post)
    {
        $this->model = $post;
    }
}
``` 

In the controller's constructor you can define the properties which are handled by the controller.
The available properties that can be defined are as follows.

### The model

This is the model, which should be passed in the constructor through Dependency Injection.

### The formFields array

This is an array of all the fields you need in the forms. Each field is declared as an array that has:
1. `name`: This is the model's attribute name, as it is in the database.
2. `label`: This is the field's label in the forms.
3. `type`: The type of the form input field that will be used. Accepted types are: 
    - text
    - textarea
    - email
    - url
    - password
    - date
    - select
    - select_multiple
    - checkbox
    - checkbox_multiple
    - radio
4. `relationship`: This is needed in case of a select, select_multiple, radio or checkbox_multiple buttons. 
You can state here the name of the relationship as it is defined in the model. 
In the example bellow, the `Post` model has a `belongsTo` relationship to `category` and a `belongsToMany` relationship to `tags`.
For `belongsTo` relationships you can use a select or a radio(group of radios) input.
For `belongsToMany` relationships you can use a select_multiple or checkbox_multiple inputs. 
5. `relFieldName`: This is optional. It is used only in case we have a relationship, to set the name of the attribute of the related model that is displayed (ie. in a select's options).
If not defined, the default attribute to be used is `name`.

```php
$this->formFields = [
    ['name' => 'title', 'label' => 'Title', 'type' => 'text'],
    ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
    ['name' => 'body', 'label' => 'Enter your content here', 'type' => 'textarea'],
    ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
    ['name' => 'published', 'label' => 'Published', 'type' => 'checkbox'],
    ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
    ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
];
```

### The `indexFields` array

These are the model's attributes that are displayed in the index page.

```php
$this->indexFields = ['title', 'category_id', 'published'];
```

If not defined, then the first of the `formFields` is shown.

### The `formTitle` (optional)

You can optionally, define the name of the model as we want it to appear in the views. 
If not defined, the name of the model will be used.

### The `bladeLayout` (optional)

This is used to define the blade layout file that will be extended by the views for the crud forms and index page.

### The option to display deleted models (`withTrashed`)

Setting this to true, will also display deleted models and offer an option to restore them.

```php
$this->withTrashed = true;
```

In order to be able to restore the models, you need to define an additional route:

```php
Route::put('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
```

### The `validationRules` array (optional)

These are the rules we want to use to validate data before saving the model.

```php
$this->validationRules = [
    'title'       => 'required|max:255',
    'slug'        => 'required|max:100',
    'body'        => 'required',
    'publish_on'  => 'date',
    'published'   => 'boolean',
    'category_id' => 'required|int',
];
```

### The `validationMessages` array (optional)

Use this to define custom messages for validation errors. For example:

```php
$this->validationMessages = [
    'body.required' => "You need to fill in the post content."
];
```

### The `validationAttributes` array (optional)

Use this to change the way an attribute's name should appear in validation error messages.

```php
$this->validationAttributes = [
    'title' => 'Post title'
];
```

## Views and themes

The package ships with two view sets ("themes") so the forms match whatever your
app uses:

- **`bootstrap`** *(default)* — Bootstrap 3 markup. Kept as the default for
  backwards compatibility. It expects Bootstrap 3 CSS (and, if `button_icons` is
  enabled, Font Awesome) to be loaded by your app's layout.
- **`tailwind`** — Tailwind CSS markup with inline SVG icons (no Font Awesome
  dependency). The bundled layout pulls Tailwind from the Play CDN so it looks
  styled out of the box; in production you should use your app's compiled Tailwind
  (set `crud-forms.blade_layout` to your own layout, or publish and edit the
  bundled one).

### Choosing a theme (no publishing required)

Publish the config file and set the `theme` option:

```
php artisan vendor:publish --provider="Achillesp\CrudForms\CrudFormsServiceProvider" --tag=config
```

```php
// config/crud-forms.php
'theme' => 'tailwind', // or 'bootstrap' (default)
```

That's all that's needed to switch the rendered forms — you do **not** have to
publish the views.

### Publishing views for customisation

If you want to edit the markup yourself, publish a theme's views. Both sets
publish to `resources/views/vendor/crud-forms`, and **published views always take
precedence** over the `theme` setting above.

```
# Bootstrap 3 views
php artisan vendor:publish --provider="Achillesp\CrudForms\CrudFormsServiceProvider" --tag=views

# Tailwind views
php artisan vendor:publish --provider="Achillesp\CrudForms\CrudFormsServiceProvider" --tag=views-tailwind
```

Because both sets publish to the same folder, only one can be published at a time.
To switch the published set, add `--force` (or delete
`resources/views/vendor/crud-forms` first). Publish by `--tag`, not by `--provider`
alone, so you copy exactly one view set.

### Which views are used? (precedence)

1. Published views in `resources/views/vendor/crud-forms`, if present.
2. Otherwise, the bundled view set chosen by `crud-forms.theme`.

### JavaScript hooks

Both themes keep CSS classes for common JavaScript libraries:
- `select2` on select inputs
- `datepicker` on date inputs
- `data-table` on the index table

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for the release history.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 
