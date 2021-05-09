<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class WishlistController extends Controller
{
    
  public function addwishlist($id)
  {
    $userid =Auth::id();
    $check =DB::table('wishlists')->where('user_id',$userid)->where('product_id',$id)->first();
    $data =array('user_id' =>$userid ,'product_id'=>$id);
  
   if(Auth::Check())
  {

    if($check)
   {
    //$notify =array('messege-id' =>'Already has in your wishlist !' ,
   // 'alert-type'=>'error' );
    //return redirect()->back()->with($notify);
return \Response::json(['error'=>'product Already Has on your wishlists']);
   }else
   {
    DB::table('wishlists')->insert($data);
   // $notify =array('messege-id' =>'	Added to wishlist !' ,
   // 'alert-type'=>'success' );
   // return redirect()->back()->with($notify);
    return \Response::json(['success'=>'product Added on wishlists']);
   } 

   }else
   {
 	// $notify =array('messege-id' =>'login to your account firstly !' ,
  // 'alert-type'=>'warning' );
 	// return redirect()->back()->with($notify);
    return \Response::json(['error'=>'At first loing your account']);
   }
 }

}
