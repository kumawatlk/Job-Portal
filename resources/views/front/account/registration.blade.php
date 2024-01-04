@extends('front.layouts.app');
@section('main')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Register</h1>
                        <form action="" name="registration_form" id="registration_form">
                            <div class="mb-3">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" class="form-control"  placeholder="Enter Name">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Password*</label>
                                <input type="password" name="password" id="Password" class="form-control" placeholder="Enter Password">
                                <p></p>
                            </div> 
                            <div class="mb-3">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Please Enter Confirm Password">
                                <p></p>
                            </div> 
                            <button class="btn btn-primary mt-2" >Register</button>
                        </form>                    
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a  href="{{ route('account.login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

{{-- @section('customJs') --}}
<script>
    $(document).ready(function() {
            $('#registration_form').submit(function(e){
                console.log("hello");
                e.preventDefault();
                $.ajax({
                    url:"{{ url('/account/proccess-register') }}",
                    type:"post",
                    data:$('#registration_form').serializeArray(),
                    dataType:'json',
                   
                    success:function(response){
                        // console.log(response);
                        if (response.status==false) {
                            var errors = response.error;
                            console.log(errors);
                            if (errors.name) {
                                $("#name").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.name);
                            }
                            if (errors.email) {
                                $("#email").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.email);
                            }
                            if (errors.password) {
                                $("#Password").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.passsword);
                            }
                            if (errors.confirm_password) {
                                $("#confirm_password").addClass("is-invalid").siblings('p').addClass('invalid-feedback').html(errors.confirm_password);
                            }
                            
                        }else{
                            $("#name").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html('');
                            $("#email").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html('');
                            $("#Password").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html('');
                            $("#confirm_password").removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html('');

                            // alert(response.msg);
                            window.location.href = "login";
                        }
                    }
                })
            });
            // Add an input event listener to remove the error message when the user types in the 'name' field
            $("#name").on('input', function () {
                $(this).removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html('');
            });
            $("#email").on('input', function () {
                $(this).removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html('');
            });
            $("#Password").on('input', function () {
                $(this).removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html('');
            });
            $("#confirm_password").on('input', function () {
                $(this).removeClass("is-invalid").siblings('p').removeClass('invalid-feedback').html('');
            });
        });
</script>

{{-- @endsection --}}
