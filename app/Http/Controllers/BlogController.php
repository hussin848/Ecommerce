<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;

class BlogController extends Controller
{
    public function blog()
    {
     $post = DB::table('posts')->join('post_categories','posts.category_id','post_categories.id')->select('posts.*','post_categories.category_name_en','post_categories.category_name_ar')->get();
     return view('pages.blog',compact('post'));
    }
    public function English()
    {
      Session::get('lang');
      Session()->forget('lang');
      Session::put('lang','english');
      return redirect()->back();
    }
     public function arabic()
    {
      Session::get('lang');
      Session()->forget('lang');
      Session::put('lang','arabic');
      return redirect()->back();
    }
    public function BlogSingle($id)
    {
    	$posts =DB::table('posts')->where('id',$id)->get();
    	return view('pages.blog_single',compact('posts'));

    }
}
