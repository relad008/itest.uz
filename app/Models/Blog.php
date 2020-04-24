<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function categories()
    {
    	return $this->belongsToMany(BlogCategory::class, 'category_blog', 'blog_id', 'category_id');
    }
}
