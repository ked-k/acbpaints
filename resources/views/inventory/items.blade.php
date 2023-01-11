@extends('inventory.layouts.tableLayout')
@section('title', 'Items')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Products</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Items</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<a href="{{url('inventory/item/new')}}" class="btn btn-primary" >Add a new Item</a>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Items's list</h6>
				<hr/>
                    <div class="row">
                        <div class="container">
                            <div class="card mt-4">
                                <div class="card-header">
                                    Import products
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('inventory/products/import') }}" method="POST" name="importform"
                                       enctype="multipart/form-data"  onsubmit="return checkfile()">
                                       @csrf
                                        <input type="file" name="file" id="myfile" required class="form-control" onchange="checkfile(this);">
                                        <br>

                                        <button class="btn btn-success">Import File</button>
                                        <script type="text/javascript" language="javascript">
                                            function checkfile(sender) {
                                                var validExts = new Array(".xlsx", ".xls", ".csv");
                                                var fileExt = sender.value;
                                                fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                                                if (validExts.indexOf(fileExt) < 0) {

                                                           swal('Error', "Invalid file selected, valid files are of " +
                                                           validExts.toString() + " types.", 'warning');
                                                           document.getElementById('myfile').value= null;
                                                  return false;

                                                }
                                                else return true;
                                            }
                                            </script>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th>Model No.</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>Costprice</th>
                                                    <th>Saleprice</th>
                                                    <th>Color</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$value->item_name.' ('.$value->uom_name.')'}}</td>
                                                    <td>{{ $value->model_no}}</td>
                                                    <td>{{ $value->description}}</td>
                                                    <td>{{ $value->unit_name}}</td>
                                                    <td>@money($value->cost_price)</td>
                                                    <td>@convert($value->sale_price)</td>
                                                    <td>{{ $value->color}}</td>

                                                    <td class="table-action">
                                                        @if($value->is_active==1)
                                                        <span class="badge badge-success float-center">Active</span>
                                                        @php($satate='Active' AND $Stvalue=1)
                                                        @elseif($value->is_active==0)
                                                        <span class="badge badge-danger float-center">InActive</span>
                                                        @php($satate='InActive' AND $Stvalue=0)
                                                        @endif
                                                        <a href="{{ url('inventory/item/edit/'.$value->item_id) }}" class="action-icon"> <i class="bx bx-edit" ></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('inventory/item/delete/'.$value->item_id) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a>
                                                           <!-- ADD NEW Category Modal -->

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



			</div>
 @endsection
