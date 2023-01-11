@extends('inventory.layouts.tableLayout')
@section('title', 'Subcategories')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">SubCategories</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{url('inventory/units')}}">Categories</a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">SubCategory Table</li>
							</ol>
						</nav>
					</div>

					<div class="ms-auto">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subCategoryModal">Add a new Subcategory</button>
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
                                                    <th>SubCategory Name</th>
                                                    <th>Category</th>
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
                                                    <td>{{ $value->subunit_name}}</td>
                                                    <td>{{ $value->unit_name}}</td>
                                                    <td>{{ $value->created_at}}</td>
                                                    <td>@if($value->SuActive==1)
                                                        <span class="badge bg-success float-center">Active</span>
                                                        @php($satate='Active' AND $Stvalue=1)
                                                        @elseif($value->SuActive==0)
                                                        <span class="badge bg-danger float-center">InActive</span>
                                                        @php($satate='InActive' AND $Stvalue=0)
                                                        @endif
                                                    </td>
                                                    <td class="table-action">
                                                        <a href="javascript: void(0);" class="action-icon"> <i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#Umodal{{ $value->SubUnitId}}"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('inventory/Subunits/delete/'.$value->SubUnitId) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a>
                                                           <!-- ADD NEW Category Modal -->
                                                        <div class="modal fade" id="Umodal{{ $value->SubUnitId}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="staticBackdropLabel">Edit subCategory</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div> <!-- end modal header -->
                                                                        <div class="modal-body">
                                                                            <form action="{{ url('inventory/Subunits/update/'.$value->SubUnitId) }}" method="POST">
                                                                                @csrf

                                                                                <div class="row">
                                                                                    <div class="col-md-12">


                                                                                        <div class="mb-3">
                                                                                            <label for="CategoryName" class="form-label">SubCategory Name</label>
                                                                                            <input type="text" id="CategoryName" value="{{ $value->subunit_name}}" class="form-control" name="subunit_name" required>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="isActive" class="form-label">State</label>
                                                                                            <select class="form-control" id="isActive" name="isActive" required>
                                                                                                <option value="{{$Stvalue}}">{{$satate}}</option>
                                                                                                <option value="1">Active</option>
                                                                                                <option value="0">InActive</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="isActive" class="form-label">Category</label>
                                                                                            <select class="form-control select2"  name="unit_name" required>
                                                                                                <option value="{{ $value->unit_id}}">{{ $value->unit_name}}</option>
                                                                                                @if(count($valueUnites)>0)
                                                                                            @foreach($valueUnites as $valueUnite)
                                                                                                <option value="{{ $valueUnite->id }}">{{ $valueUnite->unit_name}}</option>
                                                                                            @endforeach
                                                                                            @endif

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
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    @include("inventory.modals.category")
                    @include("inventory.modals.subcategory")
			</div>
 @endsection
