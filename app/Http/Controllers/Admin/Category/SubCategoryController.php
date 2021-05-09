<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SubCategoryController extends Controller
{
    //to protect this controller
     public function __construct()
    {
        $this->middleware('auth:admin');
    }
// view sub_categories
     public function subcategories(){
  	$category = DB::table('categories')->get();

  	$subcat = DB::table('subcategories')
  				->join('categories','subcategories.category_id','categories.id')
  				->select('subcategories.*','categories.category_name')
  				->get();
  	return view('admin.category.subcategory',compact('category','subcat'));
  }

// add sub_categories

 public function storesubcat(Request $request){

   	$validateData = $request->validate([
      'category_id' => 'required',
      'subcategory_name' => 'required',

   	]);

    $data = array();
    $data['category_id'] = $request->category_id;
    $data['subcategory_name'] = $request->subcategory_name;
    DB::table('subcategories')->insert($data);
    $notification=array(
            'message_id'=>'Sub Category Inserted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification); 
   }


// delete sub_categories

 public function DeleteSubcat($id){
    DB::table('subcategories')->where('id',$id)->delete();
    $notification=array(
            'message_id'=>'Sub Category Deleted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);
 
   }
// Edit sub_categories
  
  public function EditSubcat($id){

  $subcat = DB::table('subcategories')->where('id',$id)->first();
  $category = DB::table('categories')->get();
  return view('admin.category.edit_subcat',compact('subcat','category'));

  }






  public function UpdateSubcat(Request $request, $id){
     $data = array();
    $data['category_id'] = $request->category_id;
    $data['subcategory_name'] = $request->subcategory_name;
    DB::table('subcategories')->where('id',$id)->update($data);
    $notification=array(
            'message_id'=>'Sub Category Updated Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->route('sub.categories')->with($notification); 

  }










}
