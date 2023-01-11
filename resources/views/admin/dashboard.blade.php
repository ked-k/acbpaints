@extends('inventory.layouts.tableLayout')
@section('title',''.$appName.' | print')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 
            <div class="row">
                <div class="col-12">
                    <div class="card widget-inline">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-sm-6 col-xl-6">
                                    <div class="card shadow-none m-0">
                                        <div class="card-body text-center">
                                            <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{$users->count()}}</span></h3>
                                            <p class="text-muted font-15 mb-0">Users</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-5">
                                    <div class="card shadow-none m-0 border-start">
                                        <div class="card-body text-center">
                                            <i class="uil-medical-square text-muted" style="font-size: 24px;"></i>
                                            <h3><span>{{$locations->count()}}</span></h3>
                                            <p class="text-muted font-15 mb-0">locations</p>
                                        </div>
                                    </div>
                                </div>

                                
                            </div> <!-- end row -->
                        </div>
                    </div> <!-- end card-box-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pt-0">
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    <div class="text-sm-end mt-3">
                                        <h4 class="header-title mb-3  text-center">System Users</h4> 
                                    </div>                                        
                                </div>
                                <div class="col-sm-8">
                                    
                                    <div class="text-sm-end mt-3">
                                        <a  target="_blank" class="btn btn-primary mb-2 me-1" href="{{route('laratrust.roles-assignment.index')}}">Roles Assignment</a>
                                        <a type="button" href="#" class="btn btn-primary mb-2 me-1" data-bs-toggle="modal" data-bs-target="#addUser">Add User</a>
                                    </div>
                                </div><!-- end col-->
                            </div>
                        </div>
                        <div class="card-body">
                            
                                <div class="table-responsive">
                                    <table id="example2" class="table w-100 nowrap">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Title</th>
                                                <th>Name</th>
                                                <th>Facility</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $key=>$user)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$user->title}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->location_name}}</td>
                                                <td>{{$user->email}}</td> 
                                                <td>{{$user->contact}}</td>
                                                @if ($user->is_active==1)
                                                <td><span class="badge bg-success">Active</span></td> 
                                                @else
                                                <td><span class="badge bg-danger">Suspended</span></td>
                                                @endif
                                                <td class="table-action">
                                                    <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#viewUser{{$user->uid}}"> <i class="bx bx-eye"></i></a>
                                                    <a href="#" class="action-icon" data-bs-toggle="modal" data-bs-target="#editUser{{$user->uid}}"> <i class="bx bx-edit" ></i></a>
                                                    {{-- <a href="#" class="action-icon"> <i class="mdi mdi-delete"></i></a> --}}
                                                </td>
                                            </tr>
                                            @endforeach                                                  
                                        </tbody>
                                    </table>                                          
                                </div> <!-- end preview-->
                        
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
    </div>
</div>
    <!-- end row-->
    @include('admin.addUserModal')
    @endsection