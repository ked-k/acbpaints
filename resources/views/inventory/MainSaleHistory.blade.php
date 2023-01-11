@extends('inventory.layouts.tableLayout')
@section('title', 'History')
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
                            <a href="{{url('inventory/history/today')}}" class="btn btn-primary">Today</a>
                            <a href="{{url('inventory/history/Yesterday')}}" class="btn btn-primary">Yesterday</a>
                            <a href="{{url('inventory/history/main')}}" class="btn btn-primary">All</a>
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             Sale Documents
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated">
                                <a  href="{{url('inventory/sale/new/MSL'.mt_rand(1000, 9999).time())}}"  class="dropdown-item">New sale</a>
                                <a class="dropdown-item " href="{{url('inventory/history/main/confirmed')}}">Confirmed sales</a>
                                <a class="dropdown-item " href="{{url('inventory/history/main/unconfirmed')}}">Unconfirmed sales</a>
                            </div>
                        </div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Sales list</h6>
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
                                                    <th>Created By</th>
                                                    <th>Sale code</th>
                                                    <th>Type</th>
                                                    <th>Date added</th>
                                                    <th>Total Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{ $value->sale_code}}</td>
                                                    <td>{{ $value->payment_type}}</td>
                                                    <td>{{ $value->date_added}}</td>
                                                    <td>{{ $value->totalamount}} <input type="hidden" name="amount" value="{{ $value->totalamount}}"></td>
                                                    <td>
                                                        <a  href="{{ url('inventory/sales/print/'.$value->sale_code) }}"  data-toggle="tooltip" title="View!" class="action-icon"> <i class="bx bx-printer"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
<p class="text-end text-primary mt-4">Total amount: <strong><span id="totalamount"></span></strong></p>

                                </div>
                            </div>

                        </div>
                    </div>

			</div>
			<script type="text/javascript">

    window.sumInputs = function () {
        var inputs = document.getElementsByName('amount'),

            sum = 0;

        for (var i = 0; i < inputs.length; i++) {
            var ip = inputs[i];

            if (ip.name && ip.name.indexOf("total") < 0) {
                sum += parseFloat(ip.value) || 0;
            }

        }


        var ked = sum;
        var num = 'UGX: ' + ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        document.getElementById('totalamount').innerHTML = num;

    }
    sumInputs();
</script>
 @endsection
