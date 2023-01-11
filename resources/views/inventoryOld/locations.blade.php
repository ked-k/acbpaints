@extends('inventory.layouts.tableLayout')
@section('title', 'locations')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Locations</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{url('inventory/units')}}">Locations</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Locations Table</li>
							</ol>
						</nav>
					</div>

					<div class="ms-auto">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#locationModal">Add a new locations</button>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">locations list</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>SubCategory Name</th>
                                                    <th>Category</th>
                                                    <th>Date Added</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($locations)>0)
                                                @php($i=1)
                                                @foreach($locations as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->location_name}}</td>
                                                    <td>{{ $value->region_name}}</td>
                                                    <td>{{ $value->created_at}}</td>
                                                    <td>@if($value->is_active==1)
                                                        <span class="badge bg-success float-center">Active</span>
                                                        @php($satate='Active' AND $Stvalue=1)
                                                        @elseif($value->is_active==0)
                                                        <span class="badge bg-danger float-center">InActive</span>
                                                        @php($satate='InActive' AND $Stvalue=0)
                                                        @endif
                                                    </td>
                                                    <td class="table-action">
                                                        <a href="javascript: void(0);" class="action-icon"> <i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#Umodal{{ $value->id}}"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('inventory/branches/delete/'.$value->id) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a>
                                                           <!-- ADD NEW Category Modal -->
                                                        <div class="modal fade" id="Umodal{{ $value->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="staticBackdropLabel">Edit Branch/Location</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div> <!-- end modal header -->
                                                                        <div class="modal-body">
                                                                            <form action="{{ url('inventory/branches/update/'.$value->id) }}" method="POST">
                                                                                @csrf

                                                                                <div class="row">
                                                                                    <input class="form-control form-control-md mb-3" name="name" type="text" value="{{$value->location_name}}" aria-label=".form-control-sm example">
                                                                                     <input class="form-control form-control-md mb-3" name="region" type="text" value="{{$value->region_name}}" aria-label=".form-control-sm example">


                                                                                </div>
                                                                                <!-- end row-->
                                                                                <div class="d-grid mb-0 text-center">
                                                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                                                </div>

                                                                            </form>

                                                                        </div>

                                                                    </div> <!-- end modal content-->
                                                                </div> <!-- end modal dialog-->
                                                        </div> <!-- end modal-->
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    @include("inventory.modals.location")
			</div>
 @endsection
