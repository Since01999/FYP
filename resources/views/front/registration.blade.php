@extends('front/layout')
@section('page_title', 'Registration')
@section('container')
  

 <!-- Cart view section -->
 <section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="aa-myaccount-area">         
            <div class="row">
              <div class="col-md-8">
                <div class="aa-myaccount-register">                 
                 <h4>Register</h4>
                 {{-- we will submit this form using ajax --}}
                 <form action="" class="aa-login-form" id="frmRegistration">
                    
                  <label for="">Name<span>*</span></label>
                    <input type="text" placeholder="Name" name="name" required>
                    <div id="name_error" class="field_error"></div>
                    
                    <label for="" type="email">Email<span>*</span></label>
                    <input type="text" placeholder="email" name="email" required>
                    <div id="email_error" class="field_error"></div>
                    
                    <label for="">Password<span>*</span></label>
                    <input type="password" placeholder="Password" name="password" required>
                    <div id="password_error" class="field_error"></div>

                    <label for="">Mobile<span>*</span></label>
                    <input type="text" placeholder="Mobile" name="mobile" required>
                    <div id="mobile_error" class="field_error"></div>

                    <button type="submit"  class="aa-browse-btn">Register</button>                    
                    @csrf
            </form>
                </div>
                <div id="thank_you_msg" class="field_error"></div>
              </div>
            </div>          
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart vi
@endsection
