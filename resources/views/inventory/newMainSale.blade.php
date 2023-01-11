@extends('inventory.layouts.tableLayout')
@section('title', 'New Sale')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Sale</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Sale Items</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">

					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">New Sale</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-header pt-0">
                                    <form method="POST" action="{{ url('inventory/newsale/additem') }}" name="myForm"  class="needs-validation"  onsubmit="return validateForm()">
                                       @csrf
                                        <div class="row mb-2 mt-3">
                                            <input type="hidden" class="form-control" name="sale_code"  readonly value="{{ $code }}">
                                         <div class="col-sm-7">
                                                 <div class="text-sm">
                                                 <label>Item</label>
                                                 <select class="single-select form-select" name="item_id" id="item" required onchange="fill()">
                                                     <option>Select item</option>
                                                     @foreach($items as $item)
                                                         <option value="{{$item->item_id}}">{{$item->item_name.'  ('.$item->uom_name.')'}}</option>
                                                         @endforeach
                                                 </select>
                                                 </div>
                                             </div><!-- end col-->

                                             <div class="col-sm-2">
                                                <div class="text-sm">
                                                    <label>Qyantity Left</label>
                                                    <input type="text" readonly value="0" class="form-control" onchange="fill()" name="qty_left" id="qty_left" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label>Sale price</label>
                                                    <input type="number" class="form-control" id="sale_price" onchange="fill()" required name="sale_price" readonly>
                                                </div>
                                            </div><!-- end col-->


                                        </div>


                                        <div class="row mb-2 mt-3">
                                            <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label>Quantity required</label>
                                                    <input type="number" min="1" value="0" onchange="fill()"  class="form-control" required name="qty_given" id="qty_given">
                                                </div>
                                            </div>
                                             <div class="col-sm-3">
                                                 <div class="text-sm">
                                                     <label>Discount</label>
                                                     <input type="text" class="form-control" onchange="fill()" value="0" min="0" required name="discount" id="discount">
                                                 </div>
                                             </div><!-- end col-->
                                             <div class="col-sm-3">
                                                 <div class="text-sm">
                                                     <label>Total Amount</label>
                                                     <input type="text" readonly required class="form-control" name="total_amount" id="total_amount">
                                                 </div>
                                             </div>


                                             <div class="col-sm-3">
                                                 <div class="text-sm-end pt-2">
                                                     <button type="submit" class="btn btn-primary mb-2 me-1">Add item</button>
                                                 </div>
                                             </div><!-- end col-->
                                          </div>

                                         </form>
                                         <script>
                                            $(document).ready(function(){
                                            $('#item').change(function() {

                                                var itemID = $(this).val();
                                                $("#qty_left").empty();
                                                document.getElementById('discount').value =0;
                                                document.getElementById('qty_given').value =1;
                                                document.getElementById('total_amount').value =0;
                                                // $("#supplier").empty();
                                                if (itemID) {
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "{{ url('inventory/getitemQty') }}?item_id=" + itemID,
                                                        success: function(response) {

                                                            var len = 0;
                                                 if(response['data'] != null){
                                                   len = response['data'].length;
                                                 }

                                                 if(len > 0){
                                                   // Read data and create <option >
                                                   for(var i=0; i<len; i++){

                                                     var qtyleft = response['data'][i].qtyleft;
                                                    var costp =  response['data'][i].cost;

                                                    document.getElementById('qty_left').value =qtyleft;
                                                    document.getElementById('total_amount').value =costp;
                                                     document.getElementById('sale_price').value =costp;
                                                     document.getElementById('discount').value =0;
                                                     document.getElementById('qty_given').value =1;

                                                   }
                                                 }
                                                        }
                                                    });
                                                } else {
                                                    document.getElementById('discount').value =0;
                                                    document.getElementById('total_amount').value =0;
                                                    $("#qty_left").empty();
                                                    $("#sale_price").empty();
                                                    document.getElementById('qty_given').value =1;
                                                }
                                            });
                                        });
                                        </script>
                                     </div>
                                <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Item name</th>
                                                    <th>Department</th>
                                                    <th>Description</th>
                                                    <th>UOM</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Discount</th>
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
                                                    <td>{{$value->item_name}}<input type="hidden" name="item[]" value="{{$value->itemid}}"></td>
                                                    <td>{{ $value->unit_name}}</td>
                                                    <td>{{ $value->description .'  ('.$value->color.')'}}</td>
                                                    <td>{{ $value->uom_name}}</td>
                                                    <td>{{ $value->qty_given}} <input type="hidden" name="quantity[]" value="{{$value->qty_given}}"></td>
                                                    <td>@money($value->sale_price)</td>
                                                    <td>@money($value->discount)</td>
                                                    <td>@money($value->total_amount) <input type="hidden" name="amount" value="{{ $value->total_amount}} "></td>
                                                     {{-- <td> <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('inventory/sale-item/delete/?id='.$value->saleid.'&qty_given='.$value->qty_given.'&itemid='.$value->itemid) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a></td> --}}
                                                    <td>
                                                        {{-- <a onclick="return confirm('Are you sure you want to delete?');"   data-toggle="tooltip" title="Delete!"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('deleteItem').submit();"
                                                        class="action-icon"> <i class="bx bx-trash"></i></a> --}}
                                                        <form  method="POST">
                                                            {{ csrf_field() }}
                                                            <input type="number" readonly required value="{{$value->saleid}}" class="d-none" name="saleid">
                                                            <input type="number" readonly required value="{{$value->itemid}}" class="d-none" name="itemid">
                                                            <input type="text" readonly required value="{{$value->qty_given}}" class="d-none" name="qty_given">
                                                            <button onclick="return confirm('Are you sure you want to delete?');" type="submit"class="btn btn-sm" formaction="{{ url('inventory/sale-item/delete') }}"> <i class="bx bx-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                            </table>
                                        </div>
                                            <p class="text-end mt-2">Total Amount: <strong><span id="totalamt"></span></strong></p>
                                        </div>
                                        @if(count($values)>0)
                                        <form method="POST" onsubmit="return validateSale()">
                                                @csrf
                                                <div class="row m-3">
                                                    <div class="col-sm-2">
                                                        <div class="text-sm">
                                                            <label>Sale Type</label>
                                                            <select name="payment" class="form-select" onchange="ptypefill()" id="payment">
                                                                <option value="Cash">Cash</option>
                                                                <option value="Credit">Credit</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="text-sm">
                                                            <label>Amount paid</label>
                                                            <input type="text" min="1" value="0" onchange="bfill()"  class="form-control" required name="amtpaid" id="amtpaid">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="text-sm">
                                                            <label>Balance</label>
                                                            <input type="text" readonly class="form-control" onchange="bfill()" value="0" min="0" required name="balance" id="balance">
                                                        </div>
                                                    </div><!-- end col-->
                                                    <div class="col-sm-3">
                                                        <label>Customer</label>
                                                        <div class="input-group">
                                                        <select class="single-select form-select" id="customer"  name="customer">
                                                            <option value="">Customer</option>
                                                            @if(count($customers)>0)
                                                            @foreach($customers as $customer)
                                                                <option value="{{ $customer->id }}">{{ $customer->cust_name}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#SupplierModal"><i class='bx bx-add'></i>New
                                                        </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            <input type="hidden" class="form-control" name="salekcode"  readonly value="{{ $code }}">
                                            <input type="hidden" class="form-control" name="saletotalamt" id="stktotalamt" readonly>
                                            <div class="text-sm-end mt-1">
                                                <button  type="submit" class="btn btn-info m-3" formaction="{{ url('inventory/sale/saveprint') }}"> <i class="bx bx-printer"></i>Reciept</button>
                                                <button  type="submit" class="btn btn-success m-3" formaction="{{ url('inventory/sale/savenew') }}"> <i class="bx bx-save"></i>New sale</button>

                                            </div>

                                        </form>
                                         @endif
                            </div>

                        </div>
                    </div>
                    <script>

                        function fill() {

                            var qt = document.getElementById("qty_given").value-0;
                            var ds = document.getElementById("discount").value-0;
                             var salep = document.getElementById("sale_price").value-0
                             var tt = qt * salep;
                             var mytotal = tt - ds;
                             document.getElementById("total_amount").value = mytotal;


                        }


                          function ptypefill() {


                            var x = document.getElementById('payment').value;
                            //   var x = document.getElementById('option-1');
                            if(x  == 'Credit')
                            {
                                document.getElementById("amtpaid").value = 0;
                                document.getElementById("customer").setAttribute("required", "required");
                                bfill()
                            }
                            else
                            {
                                var oramt = document.getElementById("stktotalamt").value-0;
                                document.getElementById("amtpaid").value = oramt ;
                                document.getElementById("customer").removeAttribute("required");
                                bfill()
                            }
                        }

                         function bfill() {

                            var pd = document.getElementById("amtpaid").value-0;
                             var amtp = document.getElementById("stktotalamt").value-0;
                             var bal= pd - amtp ;
                            document.getElementById("balance").value = bal;

                        }
                    </script>
                    <script type="text/javascript">

                        window.sumInputs = function() {
                            var inputs = document.getElementsByName('amount'),

                                sum = 0;

                            for(var i=0; i<inputs.length; i++) {
                                var ip = inputs[i];

                                if (ip.name && ip.name.indexOf("total") < 0) {
                                    sum += parseFloat(ip.value) || 0;
                                }

                            }


                            var ked = sum;
                          var num = 'UGX: ' + ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        document.getElementById('totalamt').innerHTML = num;
                        document.getElementById('stktotalamt').value = sum;
                        var pd = document.getElementById("amtpaid").value = sum;
                        }
                        sumInputs();
                        </script>

                        <script>
                              function validateSale() {
                                var ptype = document.getElementById('payment').value;
                                  var bal = document.getElementById('balance').value;
                                 if (ptype == "Cash" && bal < 0) {
                                swal('Error', 'The sell type must be credit because the customer never fully paid! and dont forget to select a customer', 'warning');
                                    return false;
                                }
                                    else{
                                    return true;
                                }
                              }
                        </script>

<script>


    function validateForm() {

     var q1 = document.forms["myForm"]["qty_left"].value-0;
     var q2 = document.forms["myForm"]["qty_given"].value-0;
     var stm = 'Quantity on hand is: ' +q1+ ' and  quantity required is: ' +q2;
//   var x = document.forms["myForm"]["amt"].value-0;
//     var y = document.forms["myForm"]["soldamt"].value-0;
    var z  = document.forms["myForm"]["total_amount"].value;


 if (q2 > q1) {

  //  swal('Error ',+ q1 q2 + 'The availbe quatity  is less than the input/required quatity ', 'warning');
  swal('Error','Stock Quantity missing, ' + stm + '!', 'warning');
    return false;
  }
   else if (z <= 0) {
   swal('Error', 'Total price can not be equal to 0 !', 'warning');
    return false;
  }

  else{
    return true;
  }

}
                   </script>

			</div>
            @include("inventory.modals.customer")
 @endsection
