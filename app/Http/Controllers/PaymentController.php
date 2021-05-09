<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Cart;
use Session;
use Mail;
use App\Mail\InvoiceMail;

class PaymentController extends Controller
{
    
    public function Payment(Request $request)
    {
     $data = array();
     $data['name']= $request->name;
     $data['phone']= $request->phone;
     $data['email']= $request->email;
     $data['address']= $request->address;
     $data['city']= $request->city;
     $data['payment']= $request->payment;
     if ($request->payment == 'stripe') {
     	return view('pages.payment.stripe',compact('data'));
     }elseif ($request->payment == 'cash') {
     	 return view('pages.payment.cash',compact('data'));
     }elseif ($request->payment == 'ideal') {
     	# code...
     }else{
     	echo "Cash On Delivery";
     }
    }
    public function stripeCharge(Request $request){
    	 $email = Auth::user()->email;
    	$total =$request->total;

    	// Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_51I1bA8L68vxHuZE012EY8FZKbilKmUAg1y11o5dIYwDSKepX0KNuAsFJ53Sz9hahj9YK1fs5sSqItYqjxxpT8vPm00RAtxzzB1');

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create([
        'amount' => $total*100,
        'currency' => 'usd',
        'description' => 'Example charge',
        'source' => $token,
        'metadata' => ['order_id'=>uniqid()],
        ]);
        
         //dd($charge);
         $data =array();
         $data['user_id'] = Auth::id();
         $data['payment_id']= $charge->payment_method;
         $data['paying_amount']=$charge->amount;
         $data['blnc_transection']=$charge->balance_transaction;
         $data['stripe_order_id']=$charge->metadata->order_id;
         $data['shipping']=$request->vat;
         $data['total']=$request->total;
         $data['payment_type']=$request->payment_type;
         $data['status_code']=mt_rand(100000,999999);
         if (Session::has('coupon')) {
             $data['subtotal']=Session::get('coupon')['balance'];
         }else{
            $data['subtotal']=Cart::subtotal();
         }
          $data['status']=0;
          $data['date']=date('d-m-y');
          $data['month']=date('F');
          $data['year']=date('Y');
          $order_id= DB::table('orders')->insertGetId($data);
         
         Mail::to($email)->send(new invoiceMail($data));
          $shipping = array();
          $shipping['order_id']=$order_id;
          $shipping['ship_name']=$request->ship_name;
          $shipping['ship_phone']=$request->ship_phone;
          $shipping['ship_email']=$request->ship_email;
          $shipping['ship_address']=$request->ship_address;
          $shipping['ship_city']=$request->ship_city;
          DB::table('shipping')->insert($shipping);

          $content =Cart::content();
          $details=array();
          foreach($content as $row){
            $details['order_id']=$order_id;
            $details['product_id']=$row->id;
            $details['product_name']=$row->name;
            $details['color']=$row->options->color;
            $details['size']=$row->options->size;
            $details['quantity']=$row->qty;
            $details['singleprice']=$row->price;
            $details['totalprice']=$row->qty*$row->price;
            DB::table('orders_details')->insert($details);
          }

          Cart::destroy();
          if(Session::has('coupon')){
            Session::forget('copon');
          }
           $notification= array('messege-id' =>'product Successfully Added' ,
        'alert-type'=>'success' );
        return Redirect()->to('/')->with($notification);
    }



    public function CashCharge(Request $request){
       $email = Auth::user()->email;
      $total =$request->total;

    
         //dd($charge);
         $data =array();
         $data['user_id'] = Auth::id();
          $data['payment_id']='cash';
         $data['shipping']=$request->vat;
         $data['total']=$request->total;
         $data['payment_type']=$request->payment_type;
         $data['status_code']=mt_rand(100000,999999);
         if (Session::has('coupon')) {
             $data['subtotal']=Session::get('coupon')['balance'];
         }else{
            $data['subtotal']=Cart::subtotal();
         }
          $data['status']=0;
          $data['date']=date('d-m-y');
          $data['month']=date('F');
          $data['year']=date('Y');
          $order_id= DB::table('orders')->insertGetId($data);
         
         Mail::to($email)->send(new invoiceMail($data));
          $shipping = array();
          $shipping['order_id']=$order_id;
          $shipping['ship_name']=$request->ship_name;
          $shipping['ship_phone']=$request->ship_phone;
          $shipping['ship_email']=$request->ship_email;
          $shipping['ship_address']=$request->ship_address;
          $shipping['ship_city']=$request->ship_city;
          DB::table('shipping')->insert($shipping);

          $content =Cart::content();
          $details=array();
          foreach($content as $row){
            $details['order_id']=$order_id;
            $details['product_id']=$row->id;
            $details['product_name']=$row->name;
            $details['color']=$row->options->color;
            $details['size']=$row->options->size;
            $details['quantity']=$row->qty;
            $details['singleprice']=$row->price;
            $details['totalprice']=$row->qty*$row->price;
            DB::table('orders_details')->insert($details);
          }

          Cart::destroy();
          if(Session::has('coupon')){
            Session::forget('copon');
          }
           $notification= array('messege-id' =>'product Successfully Added' ,
        'alert-type'=>'success' );
        return Redirect()->to('/')->with($notification);
    }



}
