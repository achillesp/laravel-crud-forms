<?php

namespace Achillesp\Filterable\Test;

use Achillesp\CrudForms\CrudFormsServiceProvider;
use Illuminate\Database\Capsule\Manager as DB;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
        $this->migrateTables();
    }

    protected function getPackageProviders($app)
    {
        return [
            CrudFormsServiceProvider::class,
        ];
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
        DB::schema()->create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug', 100);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::schema()->create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug', 100);
            $table->timestamps();
        });

        DB::schema()->create('posts', function (Blueprint $table) {
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

        DB::schema()->create('post_tag', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('tag_id');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }
}
