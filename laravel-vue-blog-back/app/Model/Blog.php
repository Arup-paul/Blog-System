<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Blog extends Model
{
    protected $fillable = ['title','post','post_except','slug','user_id','featuredImage','metaDescription','views','jsonData'];

    public function setSlugAttribute($title){
      // $this->attributes['title'] = $title;  // title attribute
       $this->attributes['slug'] = $this->uniqueSlug($title);  // title attribute
    }

    private function uniqueSlug($title){
       $slug = Str::slug($title,'-');
       $count = Blog::where('slug','LIKE',"{$slug}%")->count();
       $newCount = $count > 0 ? ++$count : '';
       return $newCount > 0 ? "$slug-$newCount" : $slug;
    }

    public function tag(){
       return $this->belongsToMany('App\Model\Tag','blogtags');
    }
    public function cat(){
      return $this->belongsToMany('App\Model\Category','blogcategories');
    }


}
