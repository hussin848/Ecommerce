<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Illuminate\Validation\Validator\Validator;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{

public function __constractor(){

	$this->middleware('auth');
}



   public function index(){
   	 return view ('auth.passwords.change');
   }


public function changepassword(Request $request){
   	
$this->validate($request,[

'oldpassword' =>'required',
'password' =>'required',
//'password_confirmation' =>'required|comfirmed',
]);
 //i will define a variable for store the password which in database in user model

$hashedpassword = Auth::user()->password;

if(hash::check($request->oldpassword, $hashedpassword)){
$user=User::find(Auth::id());
$user->password = hash::make($request->password);
$user->save();
Auth::logout();
return redirect()->route('login')->with('SuccessMsg','password has change successfully');

}else{


return redirect()->back()->with('errorMsg','current password is not corrct');

}



   }


}
