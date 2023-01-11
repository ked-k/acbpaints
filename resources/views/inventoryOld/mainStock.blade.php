@extends('inventory.layouts.tableLayout')
@section('title', 'Items')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
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
                        <div class="dropdown btn-group">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             Stock Documents
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated">
                                <a  href="{{url('inventory/stock/new/MS'.mt_rand(1000, 9999).time())}}"  class="dropdown-item">New stock</a>
                                <a class="dropdown-item" href="{{url('inventory/confirmedStock')}}">Confirmed stock</a>
                                <a class="dropdown-item" href="{{url('inventory/unconfirmedStock')}}">Unconfirmed stock</a>
                            </div>
                        </div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Supplier's list</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Qyt Left</th>
                                                    <th>Costprice</th>
                                                    <th>Saleprice</th>
                                                    <th>Cost value</th>
                                                    <th>Sale value</th>
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
                                                    <td>{{ $value->description}}</td>
                                                    <td>{{ $value->qty_left}}</td>
                                                    <td>@money($value->cost_price)</td>
                                                    <td>@convert($value->sale_price)</td>
                                                    <td>@money($value->cost_price*$value->qty_left)<input type="hidden" value="{{$value->cost_price*$value->qty_left}}" name="costamt"></td>
                                                    <td>@convert($value->sale_price*$value->qty_left) <input type="hidden" value="{{$value->sale_price*$value->qty_left}}" name="saleamt"></td>
                                                    <td>{{ $value->color}}</td>

                                                    <td class="table-action">

                                                        <a href="{{ url('inventory/item/edit/'.$value->item_id) }}" class="action-icon"> <i class="bx bx-edit" ></i></a>

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

                        </div>
                    </div>
                    <script type="text/javascript">

                        window.sumInputs = function() {
                            var inputs = document.getElementsByName('costamt'),

                                sum = 0;

                            for(var i=0; i<inputs.length; i++) {
                                var ip = inputs[i];

                                if (ip.name && ip.name.indexOf("total") < 0) {
                                    sum += parseFloat(ip.value) || 0;
                                }

                            }


                            var ked = sum;
                          var num = 'UGX: ' + ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        document.getElementById('totalcostamt').innerHTML = num;

                        }
                        sumInputs();
                        </script>

<script type="text/javascript">

    window.sumInputs2 = function() {
        var inputs = document.getElementsByName('saleamt'),

            sum = 0;

        for(var i=0; i<inputs.length; i++) {
            var ip = inputs[i];

            if (ip.name && ip.name.indexOf("total") < 0) {
                sum += parseFloat(ip.value) || 0;
            }

        }


        var ked = sum;
      var num = 'UGX: ' + ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    document.getElementById('totalsaleamt').innerHTML = num;

    }
    sumInputs2();
    </script>


			</div>
 @endsection
