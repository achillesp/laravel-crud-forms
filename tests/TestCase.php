<?php

namespace Achillesp\CrudForms\Test;

use Illuminate\Support\Facades\Route;
use Achillesp\CrudForms\Test\Models\Tag;
use Achillesp\CrudForms\Test\Models\Post;
use Achillesp\CrudForms\Test\Models\Category;
use Illuminate\Database\Capsule\Manager as DB;
use Achillesp\CrudForms\CrudFormsServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
        $this->migrateTables();
        $this->seedTables();
    }

    protected function getPackageProviders($app)
    {
        return [
            CrudFormsServiceProvider::class,
            \Collective\Html\HtmlServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form' => \Collective\Html\FormFacade::class,
            'Html' => \Collective\Html\HtmlFacade::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->app = $app;
        $this->setRoutes();
        $app['config']->set('app.url', 'http://localhost');
        $app['config']->set('app.key', 'base64:WpZ7D2IUkBA+99f8HABIVujw2HqzR6kLGsTpDdV5nao=');
    }

    protected function setRoutes()
    {
        Route::get('/', function () {
            return 'home';
        });

        Route::resource('/post', 'Achillesp\CrudForms\Test\Controllers\PostController')->middleware('web');
        Route::put('/post/{post}/restore',
            ['as' => 'post.restore', 'uses' => 'Achillesp\CrudForms\Test\Controllers\PostController@restore'])->middleware('web');
    }

    protected function setUpDatabase()
    {
        $database = new DB();

        $database->addConnection(['driver' => 'sqlite', 'database' => ':memory:']);
        $database->bootEloquent();
        $database->setAsGlobal();
    }

    protected function migrateTables()
    {
        DB::schema()->create('categories', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug', 100);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::schema()->create('tags', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug', 100);
            $table->timestamps();
        });

        DB::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug', 100);
            $table->text('body');
            $table->date('publish_on')->nullable();
            $table->boolean('published')->default(false);
            $table->unsignedInteger('category_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        DB::schema()->create('post_tag', function ($table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('tag_id');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            $table->primary(['post_id', 'tag_id']);
        });
    }

    protected function seedTables()
    {
        for ($i = 1; $i <= 11; ++$i) {
            Category::create([
                'name' => "category $i",
                'slug' => "category-$i",
            ]);

            Tag::create([
                'name' => "tag $i",
                'slug' => "tag-$i",
            ]);
        }

        for ($i = 1; $i <= 11; ++$i) {
            $post = Post::create([
                'title'      => "post $i",
                'slug'       => "post-$i",
                'body'       => "post $i body",
                'publish_on' => date_sub(now(), date_interval_create_from_date_string("$i days")),
                'published'  => rand(0, 1),
                'category_id'=> $i,
            ]);

            $post->tags()->attach(Tag::where('id', '<=', rand(0, 10))->get());
        }
    }
}
