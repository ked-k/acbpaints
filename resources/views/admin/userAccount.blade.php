<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    {{-- <title>MERP|| Asset Management</title> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRS') }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">
    <!-- App css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{asset('assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="dark-style">

</head>

<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom topnav-navbar">
                    <div class="container-fluid">
                        <ul class="list-unstyled topbar-menu float-end mb-0">
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="account-user-avatar"> 
                                        <img src="{{asset('storage/'.$user->avatar)}}" alt="user-image" class="rounded-circle">
                                    </span>
                                    <span>
                                        <span class="account-user-name">{{$user->name}}</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                                    <!-- item-->
                                    <a href="{{route('dashboard')}}" class="dropdown-item notify-item">
                                        <i class="uil-home-alt"></i>
                                        <span>Home</span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item notify-item">
                                            <i class="mdi mdi-logout me-1"></i>
                                            <span>Logout</span>
                                        </a>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- end Topbar -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Profile -->
                            <div class="card bg-primary">
                                <div class="card-body profile-user-box">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-lg">
                                                        <img src="{{asset('storage/'.$user->avatar)}}" alt="" class="rounded-circle img-thumbnail">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <h4 class="mt-1 mb-1 text-white">{{$user->title.' '.$user->first_name.' '.$user->other_name.' '.$user->surname}}</h4>
                                                        <p class="font-13 text-white-50">{{$user->email}}</p>

                                                        <ul class="mb-0 list-inline text-light">
                                                            <li class="list-inline-item me-3">
                                                                <h5 class="mb-1">{{$user->name}}</h5>
                                                                <p class="mb-0 font-13 text-white-50">Username</p>
                                                            </li>
                                                            <li class="list-inline-item me-3">
                                                                <h5 class="mb-1">{{$user->facility->facility_name}}{{$user->facility->parent!=null?' ('.$user->facility->parent->facility_name.')':''}}</h5>
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
                                        <div class="col-sm-3">
                                            <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#updatePass{{$user->id}}" data-bs-dismiss="modal">
                                                    <i class="mdi mdi-account-edit me-1"></i> Change Password
                                                </button> 
                                            </div>
                                        </div> <!-- end col-->
                                        <div class="col-sm-2">
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



                    </div> <!-- end row -->
                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
        </div> <!-- end col-->
    </div>
</div>
</div>  
</div>

<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <script>document.write(new Date().getFullYear())</script> © Makerere Biomedical Research Centre
            </div>

        </div>
    </div>
</footer>
<!-- end Footer -->
</div>
</div>
<!-- UPDATE USER ACCOUNT DETAILS -->
<div class="modal fade" id="editUser{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">UPDATE MY ACCOUNT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{route('users.update',[$user->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="row col-md-12">
                            <div class="mb-3 col-md-2">
                                <label for="title2" class="form-label">Prefix <span class="text-danger">*</span></label>
                                <select class="form-select" id="title2" name="title" required >
                                    <option value="{{$user->title}}" selected>{{$user->title}}</option>
                                    {{-- <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Miss.">Miss.</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Eng.">Eng.</option>
                                    <option value="Prof.">Prof.</option> --}}
                                </select>
                            </div>
                            <div class="mb-3 col-md-5">
                                <label for="surname2" class="form-label">Surname<span class="text-danger">*</span></label>
                                <input type="text" id="surname2" class="form-control" name="surname" required value="{{$user->surname}}"  readonly>
                            </div>
                            <div class="mb-3 col-md-5">
                                <label for="first_name2" class="form-label">First Name<span class="text-danger">*</span></label>
                                <input type="text" id="first_name2" class="form-control" name="first_name" required value="{{$user->first_name}}" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="middle_name2" class="form-label">Middle Name</label>
                                <input type="text" id="middle_name2" class="form-control" name="other_name" value="{{$user->other_name}}" readonly>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="email2" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" id="email2" class="form-control" name="email" required value="{{$user->email}}" readonly>
                            </div> 
                            <div class="mb-3 col-md-4">
                                <label for="contact2" class="form-label">Contact<span class="text-danger">*</span></label>
                                <input type="text" id="contact2" class="form-control" name="contact" required value="{{$user->contact}}" readonly>
                            </div> 
                        </div> <!-- end col -->
                        <div class="mb-3 col-md-4">
                            <label for="facility_id" class="form-label">Facility<span class="text-danger">*</span></label>
                            <select class="form-select" id="facility_id" name="facility_id" required>
                                <option value="{{$user->facility_id}}" selected>{{$user->facility->facility_name}}{{$user->facility->parent!=null?' ('.$user->facility->parent->facility_name.')':''}}</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                            <select class="form-select" id="department" name="department_id" required>
                                <option value="{{$user->department_id}}" selected>{{$user->department_name}}</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="designation" class="form-label">Designation<span class="text-danger">*</span></label>
                            <select class="form-select" id="designation" name="designation_id" required>
                                <option value="{{$user->designation_id}}" selected>{{$user->designation_name}}</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="image2" class="form-label">Photo</label>
                            <input type="file" id="image2" class="form-control" name="avatar">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="signature2" class="form-label">Signature</label>
                            <input type="file" id="signature2" class="form-control" name="signature" disabled>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="is_active2" class="form-label">Status<span class="text-danger">*</span></label>
                            <select class="form-select" id="is_active2" name="is_active" required>
                                @if ($user->is_active==1)
                                <option value="{{$user->is_active}}" selected style="color: green">Active</option>  
                                @else
                                <option value="{{$user->is_active}}" selected style="color: red">Suspended</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"  id="submitButton2"> Update Account</button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
<!-- UPDATE PASSWORD -->
<div class="modal fade" id="updatePass{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">CHANGE PASSWORD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{route('users.update',[$user->id])}}">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="text" id="current_password" class="form-control" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" id="password" class="form-control" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                            </div>

                        </div>

                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit" onclick="this.innerHTML='Processing please wait.....';">Change Password</button>
                    </div>
                </form>
            </div>

        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->

<script src="{{asset('assets/js/vendor.min.js')}}"></script>
<script src="{{asset('assets/js/app.min.js')}}"></script>
</body>
</html>