<?php

namespace App\Http\Controllers;


use App\Model\Category;
use App\Model\Blog;
use Illuminate\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
  public function index(){
      $data = [];
      $data['categories'] = Category::select('id','categoryName')->get();
      $data['blogs'] = Blog::orderBy('id','desc')->with(['cat','user'])->limit(6)->get(['id','title','post_except','slug','user_id','featuredImage']);
      return view('home',$data);
  }

  public function singleBlog(Request $request ,$slug){
    $data = [];
    $data['blog'] = Blog::where('slug',$slug)->with(['cat','tag','user'])->first(['id','title','post','user_id','featuredImage']);
    $blog = $data['blog'];
    $category_ids = [];
    foreach($blog->cat as $cat){
      array_push($category_ids,$cat->id);
    }

    $data['relatedBlogs'] = Blog::with('user')->where('id','!=',$blog->id)->whereHas('cat',function($q) use($category_ids){
        $q->whereIn('category_id',$category_ids);
    })->limit(5)->orderBy('id','desc')->get(['id','title','post_except','slug','user_id','featuredImage']);
    return view('singleBlog',$data);
  }

  public function compose(View $view){
    $category = Category::select('id','categoryName')->get(['id','categoryName']);  
    $view->with('category',$category);  
  }

  public function categoryIndex(Request $request,$categoryName,$id){
    $blogs = Blog::with('user')->whereHas('cat',function($q) use($id){
      $q->where('category_id',$id);
  })->orderBy('id','desc')->select('id','title','post_except','slug','user_id','featuredImage')->paginate(1);
  return view('category')->with(['categoryName' => $categoryName, 'blogs'=> $blogs]);
  }
  public function tagIndex(Request $request,$tagName,$id){
    $blogs = Blog::with('user')->whereHas('tag',function($q) use($id){
      $q->where('tag_id',$id);
  })->orderBy('id','desc')->select('id','title','post_except','slug','user_id','featuredImage')->paginate(1);
  return view('tag')->with(['tagName' => $tagName, 'blogs'=> $blogs]);
  }

  public function AllBlogs(Request $request){
    $data = [];
    $data['blogs'] = Blog::orderBy('id','desc')->with(['cat','user'])->select('id','title','post_except','slug','user_id','featuredImage')->paginate(1);
    return view('blogs',$data);
  }

  public function search(Request $request){
     $str = $request->str;
     $blogs  = Blog::orderBy('id','desc')->with(['cat','user'])->select('id','title','post_except','slug','user_id','featuredImage');
     $blogs->when($str != '',function($q) use($str){
            $q->where('title','LIKE','%{$str}%')
               ->orwhereHas('cat',function($q) use($str){
             $q->where('categoryName',$str);
             })
            ->orwhereHas('tag',function($q) use($str){
            $q->where('tagName',$str);
          });
         });
         $blogs = $blogs->paginate(5);
         $blogs = $blogs->appends($request->all());
         return view('blogs')->with(['blogs' => $blogs]);
  
             
     
  }


}
