# Laravel Crud Forms

This is a Laravel package to help easily create CRUD (Create, Read, Update, Delete) forms for eloquent models (as well as an index page).
It aims to be used as a quick tool which does not interfere with the other parts of the application that it's used in.

The package provides:
- A trait to use in resource controllers and
- A series of views for displaying the forms

The views are built using bootstrap (v3), but the styling can easily be overriden.

## Installation

### Step 1: Composer

From the command line, run:

```
composer require achillesp/laravel-crud-forms
```
 
### Step 2: Service Provider (Laravel < 5.5)

If using a Laravel version before 5.5, you will need to add the service provider to your app's `providers` array in `config/app.php`:

```
Achillesp\CrudForms\CrudFormsServiceProvider::class
```

### Configuration

This package uses a config file which you can override by publishing it to your app's config dir.

```
php artisan vendor publish --provider=CrudFormsServiceProvider --tag=config
``` 

## Usage

To use the package, you need to use the trait `Achillesp\CrudForms\CrudForms` in your model's controller and define your routes.
The trait provides all the required methods for a Resource Controller, as well as a restore method in case of soft-deleted models.

### Routes

If for example you have a `Post` model, you would define the routes:

```php
Route::resource('/posts', 'PostController');
```

### Controller

Then in your `PostController`, you will need to use the trait and also define a constructor where you give the needed details of the model.

```php
use App\Post;
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

In the controller's constructor we define the properties which are handled by the controller.
The available properties we can define are as follows.

### The model

This is the model, which should be passed in the constructor through Dependency Injection.

### The formFields array

This is an array of all the fields you need in the forms. Each field is an array that has:
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
    - radio
4. `relationship`: This is needed in case of a select, select_multiple or radio buttons. 
You can state here the name of the relationship as it is defined in the model. 
In the example above, the `Post` model has a `belongsTo` relationship to `category` and a `belongsToMany` relationship to `tags`.
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

In order for the relationships to work, you also need to define an array of `relationships` in the model. 
So in the Post model, we will need this:

```php
class Post extends Model
{
    public $relationships = ['category', 'tags'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
``` 

### The `indexFields` array

These are the model's attributes that are displayed in the index page.

```php
$this->indexFields = ['title', 'category_id', 'published'];
```

### The `formTitle` (optional)

You can optionally, define the name of the model as we want it to appear in the views. If not defined, the name of the model will be used.

### The `bladeLayout` (optional)

This is used to define the blade layout file that will be extended by the views for the crud forms and index page.

### The option to display deleted models (`withTrashed`)

Setting this to true, will also display deleted models and offer an option to restore them.

```php
$this->withTrashed = true;
```

In order to be able to restore the models, you need to define an additional route:

```php
Route::put('/posts/{post}/restore', ['as' => 'posts.restore', 'uses' => 'PostController@restore']);
```

### The `validationRules` array (optional)

These are the rules we want to use to validate data before saving the model.

```php
$this->validationRules = [
    'title'       => 'string|required|max:255',
    'slug'        => 'string|required|max:100',
    'body'        => 'required',
    'publish_on'  => 'date',
    'published'   => 'boolean',
    'category_id' => 'int|required',
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

## Views

The views are built with bootstrap v.3 and also have css classes to support some common JavaScript libraries.
- select2 class is used in select inputs
- datepicker class is used in date inputs
- data-table class is used in the index view table

It is also possible to publish the views, so you can change them anyway you need. To publish them, use the following artisan command:

```
php artisan vendor publish --provider=CrudFormsServiceProvider --tag=views
``` 

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 
