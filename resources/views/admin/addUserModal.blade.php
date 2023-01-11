 <!-- ADD NEW USER Modal -->
 
 <div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New User(<span class="text-danger">*</span>is required)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="mb-3 col-md-2">
                            <label for="title" class="form-label">Prefix <span class="text-danger">*</span></label>
                            <select class="form-select" id="prefix" name="title" required>
                                <option value="Mr.">Mr.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Miss.">Miss.</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Eng.">Eng.</option>
                                <option value="Prof.">Prof.</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-5">
                            <label for="surname" class="form-label">Username<span class="text-danger">*</span></label>
                            <input type="text" id="surname" class="form-control" name="name" required value="{{ old('surname', '') }}">
                        </div>
                        <div class="mb-3 col-md-5">
                            <label for="first_name" class="form-label">Full Name<span class="text-danger">*</span></label>
                            <input type="text" id="first_name" class="form-control" name="full_name" required value="{{ old('first_name', '') }}">
                        </div>
                       
                            
                        <div class="mb-3 col-md-4">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" id="email" class="form-control" name="email" required value="{{ old('email', '') }}">
                        </div> 
                        <div class="mb-3 col-md-4">
                            <label for="contact" class="form-label">Contact<span class="text-danger">*</span></label>
                            <input type="text" id="contact" class="form-control" name="contact" required value="{{ old('contact', '') }}">
                        </div> 

                        <div class="mb-3 col-md-4">
                            <label for="facility_id" class="form-label">Location<span class="text-danger">*</span></label>
                            <select class="form-select" id="location_id" name="location_id" required>
                                <option value="" selected>Select Location</option>                          
                                 @if(count($locations)>0)
                                @foreach($locations as $facility)
                                <option value="{{ $facility->id }}">{{$facility->location_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                       
                        <div class="mb-3 col-md-4">
                            <label for="image" class="form-label">Photo</label>
                            <input type="file" id="image" class="form-control" name="avatar">
                        </div>
                      
                            
                        <div class="mb-3 col-md-4">
                            <label for="is_active" class="form-label">Status<span class="text-danger">*</span></label>
                            <select class="form-select" id="is_active" name="is_active" required>
                                <option value="1" style="color: green" selected>Active</option>
                                <option value="0" style="color: red">Suspended</option>
                            </select>
                        </div>
                           
                        <div class="mb-3 col-md-12">
                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="text" id="password" class="form-control" name="password" required min="8">
                        </div>
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"  id="submitBtn"> Add User</button>
                    </div>
                </form>
            </div>
            
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
 <!-- UPDATE USER Modal -->
@foreach ($users as $key=>$user)
 <div class="modal fade" id="editUser{{$user->uid}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">UPDATE USER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{route('users.update',[$user->uid])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="row col-md-12">
                            <div class="mb-3 col-md-4">
                                <label for="title2" class="form-label">Prefix <span class="text-danger">*</span></label>
                                <select class="form-select" id="title2" name="title" required>
                                    <option value="{{$user->title}}" selected>{{$user->title}}</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Miss.">Miss.</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Eng.">Eng.</option>
                                    <option value="Prof.">Prof.</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="surname2" class="form-label">Surname<span class="text-danger">*</span></label>
                                <input type="text" id="surname2" class="form-control" name="surname" required value="{{$user->surname}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first_name2" class="form-label">First Name<span class="text-danger">*</span></label>
                                <input type="text" id="first_name2" class="form-control" name="first_name" required value="{{$user->first_name}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="middle_name2" class="form-label">Middle Name</label>
                                <input type="text" id="middle_name2" class="form-control" name="other_name" value="{{$user->other_name}}">
                            </div>
                            
                            <div class="mb-3 col-md-4">
                                <label for="email2" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" id="email2" class="form-control" name="email" required value="{{$user->email}}">
                            </div> 
                            <div class="mb-3 col-md-4">
                                <label for="contact2" class="form-label">Contact<span class="text-danger">*</span></label>
                                <input type="text" id="contact2" class="form-control" name="contact" required value="{{$user->contact}}">
                            </div> 
                        </div> <!-- end col -->
                        <div class="mb-3 col-md-4">
                            <label for="facility_id2" class="form-label">Facility <span class="text-danger">*</span></label>
                            <select class="form-select" id="facility_id2" name="facility_id" required>
                                @if ($user->location_name!=null)
                                <option value="{{$user->facility_id}}" selected>{{$user->location_name}}</option>
                                @else
                                <option value="" selected>Select Facility</option>
                                @endif
                                @foreach ($locations as $facility)
                                <option value="{{$facility->id}}">{{$facility->location_name}}</option>
                                @endforeach
                            </select>
                        </div>
                     
                     
                            
                            <div class="mb-3 col-md-4">
                                <label for="image2" class="form-label">Photo</label>
                                <input type="file" id="image2" class="form-control" name="avatar">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="signature2" class="form-label">Signature</label>
                                <input type="file" id="signature2" class="form-control" name="signature">
                            </div>
                            
                            <div class="mb-3 col-md-4">
                                <label for="is_active2" class="form-label">Status<span class="text-danger">*</span></label>
                                <select class="form-select" id="is_active2" name="is_active" required>
                                    @if ($user->is_active==1)
                                        <option value="{{$user->is_active}}" selected style="color: green">Active</option>  
                                    @else
                                        <option value="{{$user->is_active}}" selected style="color: red">Suspended</option>
                                    @endif
                                    <option value="1" style="color: green">Active</option>
                                    <option value="0" style="color: red">Suspended</option>
                                </select>
                            </div>
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"  id="submitButton2"> Update User</button>
                    </div>
                </form>
            </div>
            
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
<!-- VIEW USER ACCOUNT DETAILS -->
@foreach ($users as $key=>$user)
<div class="modal fade" id="viewUser{{$user->id}}"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">USER DETAILS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Profile -->
                        <div class="card bg-primary">
                            <div class="card-body profile-user-box">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-lg">
                                                    <img src="{{asset('storage/'.$user->avatar)}}" alt="" class="rounded-circle img-thumbnail">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div>
                                                    <h4 class="mt-1 mb-1 text-white">{{$user->title.' '.$user->first_name.' '.$user->other.' '.$user->surname}}</h4>
                                                    <p class="font-13 text-white-50">{{$user->email}}</p>

                                                    <ul class="mb-0 list-inline text-light">
                                                       
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->name}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Username</p>
                                                        </li>
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->location_name}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Facility</p>
                                                        </li>
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->department_name}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Department</p>
                                                        </li>
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->designation_name}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Designation</p>
                                                        </li>
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->contact}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Contact</p>
                                                        </li>
                                                       
                                                        <li class="list-inline-item">
                                                            @if ($user->is_active==1)
                                                            <h5 class="mb-1" style="color: rgb(160, 221, 160)">Active</h5>  
                                                                @else
                                                            <h5 class="mb-1" style="color: red">Suspended</h5> 
                                                            @endif
                                                            <p class="mb-0 font-13 text-white-50">Status</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col-->

                                    <div class="col-sm-4">
                                        <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editUser{{$user->id}}" data-bs-dismiss="modal">
                                                <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                                            </button>
                                        </div>
                                    </div> <!-- end col-->
                                </div> <!-- end row -->

                            </div> <!-- end card-body/ profile-user-box-->
                        </div><!--end profile/ card -->
                    </div> <!-- end col-->
                </div>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
<script type="text/javascript">
    
    function generatePass()
    {
    var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var passwordLength = 8;
    var password = "";
    var passwordInput = document.getElementById("password");
    for (var i = 0; i <= passwordLength; i++) 
    {
    var randomNumber = Math.floor(Math.random() * chars.length);
    password += chars.substring(randomNumber, randomNumber +1);
    };
    passwordInput.value = password;
    passwordInput.select();
    document.execCommand("copy");  
    }

</script>
