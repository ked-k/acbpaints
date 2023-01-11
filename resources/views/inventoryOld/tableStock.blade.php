@extends('inventory.layouts.tableLayout')
@section('title', 'Table Dashboard')
@section('content')
			<div class="page-content">


                <div class="card radius-10">
					<div class="card-content">
						<div class="row row-group row-cols-1 row-cols-xl-4">
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total Items</p>
											<h4 class="mb-0 text-primary">{{$itemcount}}</h4>
										</div>
										<div class="ms-auto"><i class="bx bx-cart font-35 text-primary"></i>
										</div>
									</div>
									<div class="progress radius-10 my-2" style="height:4px;">
										<div class="progress-bar bg-primary" role="progressbar" style="width: 65%"></div>
									</div>

								</div>
							</div>
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Initial target</p>
											<h4 class="mb-0 text-danger">@convert($itemsum)</h4>
										</div>
										<div class="ms-auto"><i class="bx bx-wallet font-35 text-danger"></i>
										</div>
									</div>
									<div class="progress radius-10 my-2" style="height:4px;">
										<div class="progress-bar bg-danger" role="progressbar" style="width: 65%"></div>
									</div>

								</div>
							</div>
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Today's Sales</p>
											<h4 class="mb-0 text-success">@convert($itemTDsales)</h4>
										</div>
										<div class="ms-auto"><i class="bx bx-line-chart-down font-35 text-success"></i>
										</div>
									</div>
									<div class="progress radius-10 my-2" style="height:4px;">
										<div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
									</div>

								</div>
							</div>
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total sales</p>
											<h4 class="mb-0 text-warning">@convert($itemTsales)</h4>
										</div>
										<div class="ms-auto"><i class="bx bx-pie-chart-down font-35 text-success"></i>
										</div>
									</div>
									<div class="progress radius-10 my-2" style="height:4px;">
										<div class="progress-bar bg-primary" role="progressbar" style="width: 65%"></div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>

					<div class="row">

                        <div class="card radius-10">
                            <div class="card-header">

                                <form method="POST" action="{{ url('inventory/table/additem') }}" name="myForm"  class="needs-validation"  onsubmit="return validateForm()">
                                    @csrf
                                     <div class="row mb-2 mt-3">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Item:-</label>
                                                    <div class="input-group">
                                                        <select class="single-select form-select ml-1" name="item_id" id="item" required>
                                                            <option value="">Select item to add</option>
                                                            @foreach($items as $item)
                                                                <option value="{{$item->item_id}}">{{$item->item_name.'  ('.$item->uom_name.')'}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Sale price</label>
                                                <input type="text" name="sale_valuem" id="sale_valuem" class="form-control" readonly required>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Assumed target price</label>
                                                <input type="hidden" name="unit_id" id="unit_id" class="form-control" required>
                                                <input type="text" name="sale_value" id="sale_value" class="form-control" required>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Quantity left</label>
                                                <input type="text" name="qty_left" id="qty_left" class="form-control" readonly required>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-outline-primary px-5 mt-3"><i class='bx bx-add mr-1'></i>Add new Item</button>
                                            </div>
                                     </div>
                                     <script>
                                        $(document).ready(function(){
                                        $('#item').change(function() {

                                            var itemID = $(this).val();
                                            $("#unit_id").empty();
                                            $("#sale_value").empty();
                                            $("#sale_valuem").empty();
                                            $("#qty_left").empty();
                                            if (itemID) {
                                                $.ajax({
                                                    type: "GET",
                                                    url: "{{ url('inventory/getItem') }}?item_id=" + itemID,
                                                    success: function(response) {

                                                        var len = 0;
                                             if(response['data'] != null){
                                               len = response['data'].length;
                                             }

                                             if(len > 0){
                                               // Read data and create <option >
                                               for(var i=0; i<len; i++){

                                                 var dptid = response['data'][i].dptid;
                                                var salep =  response['data'][i].salep;
                                                var qty =  response['data'][i].qtyleft;

                                                document.getElementById('unit_id').value =dptid;
                                                 document.getElementById('sale_value').value =salep;
                                                 document.getElementById('sale_valuem').value =salep;
                                                 document.getElementById('qty_left').value =qty;
                                               }
                                             }
                                                    }
                                                });
                                            } else {

                                                $("#unit_id").empty();
                                                $("#sale_value").empty();
                                                $("#sale_valuem").empty();
                                                $("#qty_left").empty();
                                            }
                                        });
                                    });
                                    </script>
                                    <script>


                                        function validateForm() {

                                         var q1 = document.forms["myForm"]["qty_left"].value-0;
                                         var q2 = 1;
                                         var stm = 'Quantity on hand is: ' +q1+ ' and  quantity required is: ' +q2;
                                       var x = document.forms["myForm"]["sale_value"].value-0;
                                     var y = document.forms["myForm"]["sale_valuem"].value-0;
                                      //  var z  = document.forms["myForm"]["total_amount"].value;


                                     if (q2 > q1) {

                                      //  swal('Error ',+ q1 q2 + 'The availbe quatity  is less than the input/required quatity ', 'warning');
                                      swal('Error','Stock Quantity missing, ' + stm + '!', 'warning');
                                        return false;
                                      }
                                       else if (x < y) {
                                       swal('Error', 'The Assumed target can not be lower than the sale price!', 'warning');
                                        return false;
                                      }
                                      else{
                                        return true;
                                      }

                                    }
                                    </script>
                                </form>



                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>UOM</th>
                                                <th>Description</th>
                                                <th>Cartegory</th>
                                                <th>Sale value</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($values)>0)
                                            @php($i=1)
                                            @foreach($values as $value)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$value->item_name.' ('.$value->color.')'}}</td>
                                                <td>{{ $value->uom_name}}</td>
                                                <td>{{ $value->description}}</td>
                                                <td>{{ $value->unit_name}}</td>
                                                <td>@convert($value->sale_value) <input type="hidden" value="{{$value->sale_value}}" name="saleamt"></td>
                                                <td class="table-action">
                                                    <a href="javascript: void(0);" class="icon"> <i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#Umodal{{ $value->mid }}"></i></a>
                                                    {{-- <a onclick="return confirm('Are you sure you want to deactvate item?');" href="{{ url('inventory/table/delete/'.$value->mid) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a> --}}
                                                       <!-- ADD NEW Category Modal -->
                                                    <div class="modal fade" id="Umodal{{ $value->mid }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="staticBackdropLabel">Edit</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                    </div> <!-- end modal header -->
                                                                    <div class="modal-body">
                                                                        <form action="{{ url('inventory/tableIetem/update/'.$value->mid) }}" method="POST">
                                                                            @csrf

                                                                            <div class="row">
                                                                                <div class="col-md-12">


                                                                                    <div class="mb-3">
                                                                                        <label  class="form-label">Product Name</label>
                                                                                        <input type="hidden" required value="{{$value->mitem_id}}" class="form-control" name="item_id">
                                                                                        <input type="text" id="Name" value="{{$value->item_name.' ('.$value->color.')'}}" class="form-control" name="unit_name">
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label  class="form-label">Quantity available</label>
                                                                                        <input type="text" value="{{$value->qty_left}}" class="form-control" name="qty_left">
                                                                                        <input type="number" max="{{$value->qty_left}}" readonly value="1" class="form-control d-none" name="qty_req">
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label  class="form-label">Assumed target price</label>
                                                                                        <input type="text" id="sale_value" value="{{$value->sale_price}}" class="form-control" name="sale_value">
                                                                                    </div>

                                                                                </div> <!-- end col -->

                                                                            </div>
                                                                            <!-- end row-->
                                                                            <div class="d-grid mb-0 text-center">
                                                                                <button class="btn btn-primary" type="submit">Update value</button>
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
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-left text-primary mt-4">Total costAmount: <strong><span id="totalcostamt"></span></strong></p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-end text-primary mt-4">Total sale Amount: <strong><span id="totalsaleamt"></span></strong></p>
                                        </div>
                                </div>

                            </div>
                        </div>

					 </div><!--end row-->



			</div>
 @endsection
