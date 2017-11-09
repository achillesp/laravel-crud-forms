<?php

namespace Achillesp\CrudForms\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
