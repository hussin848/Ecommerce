<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Response;
use Auth;
use Session;

class FrontController extends Controller
{
    
 public function StoreNewslater(Request $request){
    	$validateData = $request->validate([
     'email' => 'required|unique:newslaters|max:55',
    	]);

   $data = array();
   $data['email'] = $request->email;
   DB::table('newslaters')->insert($data);
   $notification=array(
            'messege-id'=>'Thanks for Subscribing',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification); 	

    }

    public function OrderTraking(Request $request ){

      $code = $request->code;
      $track=DB::table('orders')->where('status_code',$code)->first();
      if($track){
      //echo"<pre>"
      //print_r($track);
        

        return view('pages.tracking',compact('track'));
      }else{
         $notification=array(
            'messege-id'=>'Status Code INVALid',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);  

      }
    }
    public function OrderDetails($id){
      
       $order = DB::table('orders')->join('users','orders.user_id','users.id')->select('orders.*','users.name','users.phone')->where('orders.id',$id)->first();
        $shipping =DB::table('shipping')->where('order_id',$id)->first();



      $details=DB::table('orders_details')->join('products','orders_details.product_id','products.id')->select('orders_details.*','products.product_code','products.image_one')->where('orders_details.order_id',$id)->get();
      return view('pages.orderdetalise',compact('details','shipping','order'));
    }




}
