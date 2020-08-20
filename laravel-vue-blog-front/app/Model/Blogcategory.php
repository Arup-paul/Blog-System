<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blogcategory extends Model
{
    protected $fillable = ['category_id','blog_id'];
}
