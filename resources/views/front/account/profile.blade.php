@extends('front.layouts.app')
@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <form action="" id="profileform" method="POST">    
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body  p-4">
                            <h3 class="fs-4 mb-1">My Profile</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text" placeholder="Enter Name" name="name" id="name" class="form-control" @error('name') is-invalid @enderror value="{{ $user_data['name'] }}">
                                <p></p>     
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" placeholder="Enter Email" name="email" id="email" class="form-control" @error('email') is-invalid @enderror value="{{ $user_data['email'] }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Designation*</label>
                                <input type="text" placeholder="Designation" name="designation" id="designation" class="form-control" @error('designation') is-invalid @enderror value="{{ $user_data['designation'] }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Mobile*</label>
                                <input type="text" placeholder="Mobile" name="mobile" id="mobile" class="form-control" value="{{ $user_data['mobile'] }}">
                                <p></p>
                            </div>                        
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">Change Password</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Old Password*</label>
                            <input type="password" placeholder="Old Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">New Password*</label>
                            <input type="password" placeholder="New Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" placeholder="Confirm Password" class="form-control">
                        </div>                        
                    </div>
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="profilepicform" enctype='multipart/form-data'>
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image"  name="image">
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div> --}}

@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
        $(document).ready(function() {
            $('#profileform').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url:"{{ route('account.profile_update') }}",
                    type:"post",
                    data:$('#profileform').serializeArray(),
                    dataType:"json",
                    success:function(response){
                        console.log(response);
                        if (response.status==false) {
                            var error = response.error;
                                if (error.name) {
                                    $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.name);
                                }
                                if(error.email){
                                    $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.email);
                                }
                                if(error.designation){
                                    $('#designation').addClass('is-invalid').siblings('p').addClass('invalid-beedback').html(error.designation);
                                }
                                if(error.mobile){
                                    $('#mobile').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error.mobile);
                                }
                                                    
                        }

                        $('#name').on('input',function(){
                            $(this).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        });
                        $('#email').on('input',function(){
                            $(this).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        });
                        $('#designation').on('input',function(){

                            $(this).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        });
                        $('#mobile').on('input',function(){
                            $(this).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        });

                        if (response.status == true) {
                            window.location.href  = '';
                        }
                    }

                });
            });


        });
</script>
