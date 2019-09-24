<?php

namespace Achillesp\CrudForms\Test;

use Achillesp\CrudForms\Test\Models\Post;

class CrudFormsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_loads_all_resources_in_the_index()
    {
        $posts = Post::all()->load(['category', 'tags']);
        $response = $this->get('/post');

        $response->assertViewHas('entities', $posts)
                    ->assertSee($posts[0]->title);
    }

    /** @test */
    public function it_shows_a_single_resource()
    {
        $post = Post::find(1)->load(['category', 'tags']);
        $response = $this->get('/post/1');

        $response->assertViewHas('entity', $post)
                    ->assertSee($post->title);
    }

    /** @test */
    public function it_loads_the_form_for_editing_resource()
    {
        $post = Post::find(1)->load(['category', 'tags']);
        $response = $this->get('/post/1/edit');

        $response->assertViewHas('entity', $post)
                    ->assertSee('Submit Form')
                    ->assertSee($post->title);
    }

    /** @test */
    public function it_loads_the_form_for_creating_a_resource()
    {
        $response = $this->get('/post/create');

        $response->assertSee('Submit Form');
    }

    /** @test */
    public function it_can_create_a_new_resource()
    {
        $this->post('/post', [
            'title'      => 'post X',
            'slug'       => 'post-x',
            'body'       => 'post X body',
            'publish_on' => now(),
            'published'  => 1,
            'category_id'=> 1,
        ]);

        $this->assertCount(1, Post::where('title', '=', 'post X')->get());
    }

    /** @test */
    public function it_can_update_a_resource()
    {
        $this->assertCount(0, Post::where('title', '=', 'post X')->get());

        $this->put('/post/1', [
            'title'      => 'post X',
            'slug'       => 'post-x',
            'body'       => 'post X body',
            'publish_on' => now(),
            'published'  => 1,
            'category_id'=> 1,
        ]);

        $this->assertCount(1, Post::where('title', '=', 'post X')->get());
    }

    /** @test */
    public function it_can_delete_a_resource()
    {
        $postCount = Post::all()->count();
        $this->delete('/post/1');

        $this->assertSame($postCount - 1, Post::all()->count());
    }

    /** @test */
    public function it_can_restore_a_soft_deleted_resource()
    {
        $postCount = Post::all()->count();
        $this->delete('/post/1');

        $this->assertSame($postCount - 1, Post::all()->count());

        $this->get('/post')->assertSee('Restore');

        $this->put('/post/1/restore');

        $this->assertSame($postCount, Post::all()->count());
    }
}
