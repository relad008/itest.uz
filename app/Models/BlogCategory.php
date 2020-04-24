<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function blogs()
    {
    	return $this->belongsToMany(Blog::class, 'category_blog', 'category_id', 'blog_id');
    }
}
