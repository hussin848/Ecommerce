<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

 public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index(){

       return view('admin.home');

    }







     public function ChangePassword()
    {
        return view('admin.auth.passwordchange');
    }


 public function Update_pass(Request $request)
    {
      $password=Auth::user()->password;
      $oldpass=$request->oldpass;
      $newpass=$request->password;
      $confirm=$request->password_confirmation;
      if (Hash::check($oldpass,$password)) {
           if ($newpass === $confirm) {
                      $user=Admin::find(Auth::id());
                      $user->password=Hash::make($request->password);
                      $user->save();
                      Auth::logout();  
                      $notification=array(
                        'message_id'=>'Password Changed Successfully ! Now Login with Your New Password',
                        'alert-type'=>'info'
                         );
                       return Redirect()->route('admin.login')->with($notification); 
                 }else{
                     $notification=array(
                        'message_id'=>'New password and Confirm Password not matched!',
                        'alert-type'=>'error'
                         );
                       return Redirect()->back()->with($notification);
                 }     
      }else{
        $notification=array(
                'message_id'=>'Old Password not matched!',
                'alert-type'=>'error'
                 );
               return Redirect()->back()->with($notification);
      }
    }





    public function logout()
    {
        Auth::logout();
            $notification=array(
                'message_id'=>'Successfully Logout',
                'alert-type'=>'info'
                 );
             return Redirect()->route('admin.login')->with($notification);
    }





}
