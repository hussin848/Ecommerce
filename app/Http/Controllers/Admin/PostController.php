<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Image;
class PostController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    



   public function BlogCatlist()
    {
      $blogcat = DB::table('post_categories')->get();
      return view('admin.blog.category.index', compact('blogcat'));
    }


    public function BlogCatStore(Request $request)
    {
       $validateData = $request->validate([
     'category_name_en' => 'required|unique:post_categories|max:255',
      'category_name_ar' => 'required|unique:post_categories|max:255',
     ]);
     $data = array();
 	 $data['category_name_en'] = $request->category_name_en;
 	 $data['category_name_ar'] = $request->category_name_ar;
 	 $brand = DB::table('post_categories')->insert($data);
        $notification=array(
            'message_id'=>'Blog Added Successfully',
            'alert-type'=>'success'
             );
            return Redirect()->back()->with($notification);
    }
    public function DeleteBlogCat($id)
    {
     DB::table('post_categories')->where('id',$id)->delete();
     $notification=array(
            'message_id'=>'Blog Deleted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);
    }



     public function EditBlogCat($id)
    {
      $blogcatedit = DB::table('post_categories')->where('id',$id)->first();
     return view('admin.blog.category.edit',compact('blogcatedit'));
    }


    public function UpdateBlogCat(Request $request, $id)
    {
     $data = array();
 	 $data['category_name_en'] = $request->category_name_en;
 	 $data['category_name_ar'] = $request->category_name_ar;
      $update=DB::table('post_categories')->where('id',$id)->update($data);
      if ($update) 
      {
        $notification=array(
            'message_id'=>'Blog Updated Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->route('add.blog.categorylist')->with($notification);
      } else
      {
         $notification=array(
            'message_id'=>'Nothing To Update',
            'alert-type'=>'error'
             );
           return Redirect()->route('add.blog.categorylist')->with($notification);
      }
    }

      public function Create()
    {
      $blogcategory = DB::table('post_categories')->get();
      return view('admin.blog.create', compact('blogcategory'));
    }


    public function store(Request $request)
    {
      
     $data = array();
 	 $data['post_title_en'] = $request->post_title_en;
 	 $data['post_title_ar'] = $request->post_title_ar;
 	 $data['category_id'] = $request->category_id;
 	 $data['details_en'] = $request->details_en;
 	 $data['details_ar'] = $request->details_ar;
 	 $post_image =$request->file('post_image');

        if ($post_image ) {
     $post_image_name = hexdec(uniqid()).'.'.$post_image->getClientOriginalExtension();
     Image::make($post_image)->resize(300,300)->save('public/media/post/'.$post_image_name);
     $data['post_image'] = 'public/media/post/'.$post_image_name;

    
      DB::table('posts')->insert($data);
      $notification=array(
            'message_id'=>'post Inserted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);
 
 
    }else{



 	 $data ['post_image']='';
 	 DB::table('posts')->insert($data);
        $notification=array(
            'message_id'=>'Post Added Successfully',
            'alert-type'=>'success'
             );
            return Redirect()->back()->with($notification);
    }

    }

      public function index(){
         $post = DB::table('posts')
                    ->join('post_categories','posts.category_id','post_categories.id')
                    ->select('posts.*','post_categories.category_name_en')
                    ->get();
                    
                  //   return response()->json($product);
             return view('admin.blog.index',compact('post'));

    }




    public function DeletePost($id)
    {
     $post= DB::table('posts')->where('id',$id)->first();
     $image =$post->post_image;
     unlink($image);
     DB::table('posts')->where('id',$id)->delete();
     $notification=array(
            'message_id'=>'Post Deleted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);
    }



     public function EditPost($id)
    {
      $post = DB::table('posts')->where('id',$id)->first();
     return view('admin.blog.edit',compact('post'));
    }


    public function UpdatePost(Request $request, $id)
    {
     
     $data = array();
 	 $data['post_title_en'] = $request->post_title_en;
 	 $data['post_title_ar'] = $request->post_title_ar;
 	 $data['category_id'] = $request->category_id;
 	 $data['details_en'] = $request->details_en;
 	 $data['details_ar'] = $request->details_ar;
 	 $post_image =$request->file('post_image');

        if ($post_image ) {
        	unlink($oldimage);
     $post_image_name = hexdec(uniqid()).'.'.$post_image->getClientOriginalExtension();
     Image::make($post_image)->resize(300,300)->save('public/media/post/'.$post_image_name);
     $data['post_image'] = 'public/media/post/'.$post_image_name;

    
      DB::table('posts')->where('id',$id)->update($data);
      $notification=array(
            'message_id'=>'post Updated Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->route('all.blogpost')->with($notification);
 
 
    }else{



 	 $data ['post_image']=$oldimage;
 	 DB::table('posts')->where('id',$id)->update($data);
        $notification=array(
            'message_id'=>'Post Updated Successfully',
            'alert-type'=>'success'
             );
            return Redirect()->route('all.blogpost')->with($notification);
     }
    }








}
