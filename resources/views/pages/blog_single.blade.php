@extends('layouts.app')
@section('content')

     <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Product Details: <span class="tx-danger">*</span></label>
                  <br>
                 <p>   {!! $product->product_details !!} </p>
    
                </div>
              </div><!-- col-4 -->


 @endsection