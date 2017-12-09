<?php

namespace Achillesp\CrudForms\Test\Controllers;

use Achillesp\CrudForms\CrudForms;
use Illuminate\Routing\Controller;
use Achillesp\CrudForms\Test\Models\Post;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use CrudForms;

    public function __construct(Post $post)
    {
        $this->indexFields = ['title', 'category_id', 'published'];

        $this->formFields = [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text'],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'body', 'label' => 'Enter your content here', 'type' => 'textarea'],
            ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
            ['name' => 'published', 'label' => 'Published', 'type' => 'checkbox'],
            ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
            ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
        ];

        $this->withTrashed = true;

        $this->validationRules = [
            'title'       => 'string|required|max:255',
            'slug'        => 'string|required|max:100',
            'body'        => 'required',
            'publish_on'  => 'date',
            'published'   => 'boolean',
            'category_id' => 'int|required',
        ];

        $this->validationMessages = [
            'body.required' => 'You need to fill in the post content.',
        ];

        $this->validationAttributes = [
            'title' => 'Post title',
        ];

        $this->model = $post;
    }
}
