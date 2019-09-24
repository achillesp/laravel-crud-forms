<?php

namespace Achillesp\CrudForms\Test;

use Carbon\Carbon;
use Achillesp\CrudForms\Test\Models\Tag;
use Achillesp\CrudForms\Test\Models\Post;
use Achillesp\CrudForms\Test\Models\Category;
use Illuminate\Database\Capsule\Manager as DB;
use Achillesp\CrudForms\CrudFormsServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Achillesp\CrudForms\Test\Providers\RouteServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
        $this->migrateTables();
        $this->seedTables();
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            CrudFormsServiceProvider::class,
            RouteServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->app = $app;
        $app['config']->set('app.url', 'http://localhost');
        $app['config']->set('app.key', 'base64:WpZ7D2IUkBA+99f8HABIVujw2HqzR6kLGsTpDdV5nao=');
    }

    /**
     * Setup the test database.
     *
     * @return void
     */
    protected function setUpDatabase()
    {
        $database = new DB();

        $database->addConnection(['driver' => 'sqlite', 'database' => ':memory:']);
        $database->bootEloquent();
        $database->setAsGlobal();
    }

    /**
     * Run migrations on test database.
     *
     * @return void
     */
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

    /**
     * Seed test tables with dummy data.
     *
     * @return void
     */
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
                'publish_on' => date_sub(Carbon::now(), date_interval_create_from_date_string("$i days")),
                'published'  => rand(0, 1),
                'category_id'=> $i,
            ]);

            $post->tags()->attach(Tag::where('id', '<=', rand(0, 10))->get());
        }
    }
}
