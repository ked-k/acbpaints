@extends('inventory.layouts.tableLayout')
@section('title', 'Dashboard')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Categories</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Category Table</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">Add a new category</button>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Category list</h6>
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
                                                    <th>Category Name</th>
                                                    <th>Date Added</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->unit_name}}</td>
                                                    <td>{{ $value->created_at}}</td>
                                                    <td>@if($value->is_active==1)
                                                        <span class="badge bg-success">Active</span>
                                                        @php($satate='Active' AND $Stvalue=1)
                                                        @elseif($value->is_active==0)
                                                        <span class="badge bg-danger">InActive</span>
                                                        @php($satate='InActive' AND $Stvalue=0)
                                                        @endif
                                                    </td>
                                                    <td class="table-action">
                                                        <a href="javascript: void(0);" class="icon"> <i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#Umodal{{ $value->id }}"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('inventory/units/delete/'.$value->id) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a>
                                                           <!-- ADD NEW Category Modal -->
                                                        <div class="modal fade" id="Umodal{{ $value->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="staticBackdropLabel">Edit Category</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div> <!-- end modal header -->
                                                                        <div class="modal-body">
                                                                            <form action="{{ url('inventory/units/update/'.$value->id) }}" method="POST">
                                                                                @csrf

                                                                                <div class="row">
                                                                                    <div class="col-md-12">


                                                                                        <div class="mb-3">
                                                                                            <label for="CategoryName" class="form-label">Category Name</label>
                                                                                            <input type="text" id="CategoryName" value="{{ $value->unit_name}}" class="form-control" name="unit_name">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="isActive" class="form-label">State</label>
                                                                                            <select class="form-control" id="isActive" name="isActive">
                                                                                                <option value="{{$Stvalue}}">{{$satate}}</option>
                                                                                                <option value="1">Active</option>
                                                                                                <option value="0">InActive</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div> <!-- end col -->

                                                                                </div>
                                                                                <!-- end row-->
                                                                                <div class="d-grid mb-0 text-center">
                                                                                    <button class="btn btn-primary" type="submit">Update Category</button>
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
                                            <tfoot>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Category Name</th>
                                                    <th>Date Added</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    @include("inventory.modals.category")
			</div>
 @endsection
