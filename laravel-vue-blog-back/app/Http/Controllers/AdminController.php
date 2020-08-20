<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Tag;
use App\Model\Blog;
use App\Model\Blogcategory;
use App\Model\Blogtag;
use App\Role;
use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {
    //home page
    public function index( Request $request ) {
        //first check if you are logged in and admin user
        if ( !Auth::check() && $request->path() != 'login' ) {
            return redirect( '/login' );
        }

        if ( !Auth::check() && $request->path() == 'login' ) {
            return view( 'welcome' );
        }
        //you are already logged in .. to check for if you are admin user

        $user = Auth::user();
        if ( $user->userType == 'User' ) {
            return redirect( '/login' );
        }

        if ( $request->path() == 'login' ) {
            return redirect( '/' );
        }



        return $this->checkForPermission($user,$request);


    }

    //user permission
    public function checkForPermission($user,$request){

       $permission = json_decode($user->role->permission);

      $hasPermission = false;
      if(!$permission) return view( 'welcome' );
      foreach($permission as $p){
         if($p->name == $request->path() ){
           if($p->read){
               $hasPermission = true;
           }
         }
      }
      if($hasPermission)
      return view( 'welcome' );
      return view( 'notfound' );



    }
     //logout
    public function logout() {
        Auth::logout();
        return redirect( '/login' );
    }
    //add a new tag
    public function addTag( Request $request ) {
        //validate request
        $this->validate( $request, [
            'tagName' => 'required ',
        ] );
        return Tag::create( [
            'tagName' => $request->tagName,
        ] );
    }
    // get all tag
    public function getTag() {
        return Tag::orderBy( 'id', 'desc' )->get();
    }
     // edit tag
    public function editTag( Request $request ) {
        //validate request
        $this->validate( $request, [
            'id' => 'required ',
            'tagName' => 'required ',
        ] );
        return Tag::where( 'id', $request->id )->update( [
            'tagName' => $request->tagName,
        ] );

    }
    //delete tag
    public function deleteTag( Request $request ) {
        //validate request
        $this->validate( $request, [
            'id' => 'required ',
        ] );
        return Tag::where( 'id', $request->id )->delete();

    }
    //upload image
    public function upload( Request $request ) {
        $this->validate( $request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ] );
        $picName = time() . '.' . $request->file->extension();
        $request->file->move( public_path( 'uploads' ), $picName );
        return $picName;
    }



    //upload image for editor js

    public function uploadEditorImage(Request $request){

        $this->validate( $request, [
            'image' => 'required|mimes:jpeg,jpg,png',
        ] );
        $picName = time() . '.' . $request->image->extension();
        $request->image->move( public_path( 'uploads/blogs' ), $picName );
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => "http://127.0.0.1:8000/uploads/blogs/$picName"
            ]
        ]);
        return $picName;
    }

   




    //delete image
    public function deleteImage( Request $request ) {
        $fileName = $request->imageName;
        $this->deleteImageFromServer( $fileName );
        return 'done';
    }
     // delete image from server
    public function deleteImageFromServer( $fileName, $hasFullPath = false ) {
        if ( !$hasFullPath ) {

            $filePath = public_path() . $fileName;

        }
        if ( file_exists( $filePath ) ) {
            @unlink( $filePath );
        }
        return;
    }
   // add new category
    public function addCategory( Request $request ) {
        $this->validate( $request, [
            'categoryName' => 'required ',
            'IconImage' => 'required ',
        ] );
        return Category::create( [
            'categoryName' => $request->categoryName,
            'IconImage' => $request->IconImage,
        ] );
    }
    // get all category
    public function getCategory() {
        return Category::orderBy( 'id', 'desc' )->get();
    }
     // edit category
    public function editCategory( Request $request ) {
        //validate request
        $this->validate( $request, [
            'id' => 'required ',
            'categoryName' => 'required',
            'IconImage' => 'required',
        ] );
        return Category::where( 'id', $request->id )->update( [
            'categoryName' => $request->categoryName,
            'IconImage' => $request->IconImage,
        ] );
    }

    public function deleteCategory( Request $request ) {
        //first delete orginal file from the serve
        $this->deleteImageFromServer( $request->IconImage );

        $this->validate( $request, [
            'id' => 'required',
        ] );

        return Category::where( 'id', $request->id )->delete();
    }
     // delete category
    public function createUser( Request $request ) {
        $this->validate( $request, [
            'fullName' => 'required ',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'role_id' => 'required ',
        ] );
        $password = bcrypt( $request->password );
        $user     = User::create( [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->userType,
        ] );

        return $user;
    }
     //get users
    public function getUsers() {
        return User::where( 'role_id', '!=', '0' )->get();
    }
    // edit user
    public function editUser( Request $request ) {

        $this->validate( $request, [
            'fullName' => 'required',
            'email' => "bail|required|email|unique:users,email,$request->id",
            'password' => 'min:6',
            'role_id' => 'required ',
        ] );
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'role_id' => $request->userType,
        ];

        if ( $request->password ) {
            $password         = bcrypt( $request->password );
            $data['password'] = $password;
        }

        $user = User::where( 'id', $request->id )->update( $data );

        return $user;
    }
   // admin login
    public function adminLogin( Request $request ) {
        $this->validate( $request, [
            'email' => 'bail|required|email',
            'password' => 'bail|min:6|required',
        ] );

        if ( Auth::attempt( ['email' => $request->email, 'password' => $request->password] ) ) {
            $user = Auth::user();
            if ( $user->role->isAdmin== 0 ) {
                Auth::logout();
                return response()->json( [
                    'msg' => 'Incorrect  Login Details',
                ], 401 );
            }

            return response()->json( [
                'msg' => 'you are logged in',
                'user' => $user,
            ] );
        } else {
            return response()->json( [
                'msg' => 'Incorrect  Login Details',
            ], 401 );
        }

    }
    // create a new role
    public function createRole( Request $request ) {
        $this->validate( $request, [
            'roleName' => 'required ',
        ] );
        $role = Role::create( [
            'roleName' => $request->roleName,
        ] );

        return $role;
    }
    //  get all role
    public function getRole() {
        return Role::orderBy( 'id', 'asc' )->get();
    }
    // edit role
    public function editRole( Request $request ) {
        //validate request
        $this->validate( $request, [
            'id' => 'required ',
            'roleName' => 'required ',
        ] );
        return Role::where( 'id', $request->id )->update( [
            'roleName' => $request->roleName,
        ] );

    }
     //delete role
    public function deleteRole( Request $request ) {
        $this->validate( $request, [
            'id' => 'required',
        ] );

        return Role::where( 'id', $request->id )->delete();
    }
    // assign role
    public function AssignRole(Request $request){
           $this->validate( $request, [
            'permission' => 'required',
            'id' => 'required',
        ] );
        return Role::where('id',$request->id)->update([
          'permission' => $request->permission
        ]);
    }
     //slug
    public function slug(){  // create slug
        $title = 'This is a nice title cc';
        return Blog::create([
             'title' => $title,
             'post' => 'some post',
             'post_except' => 'aa',
             'user_id' =>1,
             'metaDescription' => 'gd',
        ]);
        return $title;
    }
    //create blog
    public function createBlog(Request $request){
        $this->validate( $request, [
            'title' => 'required',
            'post' => 'required',
            'post_except' => 'required',
            'metaDescription' => 'required',
            'jsonData' => 'required',
            'category_id' => 'required',
            'tag_id' => 'required',
        ] );
        $categories = $request->category_id;
        $tags = $request->tag_id;
        $blogCategories = [];
        $blogTags = [];
        DB::beginTransaction();

        try {
            //insert blog post
         $blog = Blog::create([
            'title' => $request->title,
            'slug' => $request->title,
            'post' => $request->post,
            'post_except' => $request->post_except,
            'user_id' =>Auth::user()->id,
            'metaDescription' => $request->metaDescription,
            'jsonData' => $request->jsonData,
       ]);
       //insert blog category
       foreach($categories as $c){
        array_push($blogCategories,['category_id' => $c, 'blog_id' => $blog->id]);
        }
       Blogcategory::insert($blogCategories);
        //insert blog tag
        foreach($tags as $t){
            array_push($blogTags,['tag_id' => $t, 'blog_id' => $blog->id]);
         }
           Blogtag::insert($blogTags);
           DB::commit();
           return 'done';
        } catch (\Throwable $th) {
            DB::rollback();
            return 'not done here';
        }


      }
      // get blog data
      public function blogdata(Request $request){
          return Blog::with(['tag','cat'])->orderBy('id','desc')->paginate($request->total);
      }
      // delete blog data
      public function deleteBlog(Request $request){
        return Blog::where('id',$request->id)->delete();
      }
     // get single blog item from edit
      public function singleBlogItem(Request $request,$id){
           return BLog::with(['tag','cat'])->where('id',$id)->first();
      }

      //update blog
      public function updateBlog(Request $request,$id){
        $this->validate( $request, [
            'title' => 'required',
            'post' => 'required',
            'post_except' => 'required',
            'metaDescription' => 'required',
            'jsonData' => 'required',
            'category_id' => 'required',
            'tag_id' => 'required',
        ] );
        $categories = $request->category_id;
        $tags = $request->tag_id;
        $blogCategories = [];
        $blogTags = [];
        DB::beginTransaction();

        try {
            //insert blog post
         $blog = Blog::where('id',$id)->update([
            'title' => $request->title,
            'slug' => $request->title,
            'post' => $request->post,
            'post_except' => $request->post_except,
            'user_id' =>Auth::user()->id,
            'metaDescription' => $request->metaDescription,
            'jsonData' => $request->jsonData,
       ]);


       //update blog category
       foreach($categories as $c){
        array_push($blogCategories,['category_id' => $c, 'blog_id' => $id]);
        }

       //delete all previous category
       Blogcategory::where('blog_id',$id)->delete();
       Blogcategory::insert($blogCategories);
        //insert blog tag
        foreach($tags as $t){
            array_push($blogTags,['tag_id' => $t, 'blog_id' => $id]);
         }
          //delete all previous tag
           Blogtag::where('blog_id',$id)->delete();
           Blogtag::insert($blogTags);
           DB::commit();
           return 'done';
        } catch (\Throwable $th) {
            return $th;
            DB::rollback();
            return 'not done here';
        }


      }





}
