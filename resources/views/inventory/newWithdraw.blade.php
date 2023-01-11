@extends('inventory.layouts.formLayout')
@section('title',''.$appName.' | New Withdraw')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Withdraw</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Withdraw</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">

					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Receive Withdraw</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-header pt-0">
                                    <form method="POST" action="{{ url('inventory/withdraw/add') }}" name="myForm"  class="needs-validation"  onsubmit="return validateForm()">
                                       @csrf
                                        <div class="row mb-2 mt-3">
                                            <input type="hidden" class="form-control" name="reff_number"  readonly value="{{ rand(8960,765555).time() }}">
                                            <div class="col-sm-4">
                                                <div class="text-sm">
                                                <label>Withdrawing Customer</label>
                                                <select class="single-select form-select" name="customer_id" id="cust_id" required >
                                                    <option value="">Select customer</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{$customer->id}}">{{$customer->cust_name.'  ('.$customer->balance.')'}}</option>
                                                        @endforeach
                                                </select>
                                                </div>
                                                <input type="hidden" readonly  class="form-control"  name="custname" id="to_acct" required>

                                            </div>

                                            <div class="col-sm-5">
                                                 <div class="text-sm">
                                                 <label>Given by</label>
                                                 <select class="single-select form-select" name="to_acct" id="from_id" required >
                                                     <option>{{auth()->user()->name}}</option>                                                  
                                                 </select>
                                                 </div>
                                                 <input type="hidden" readonly  class="form-control"  name="to_name" id="from_acct" required>
                                             </div><!-- end col-->

                                             <div class="col-sm-3 ">
                                                <div class="text-sm">
                                                    <label>Amount available (UGX)</label>
                                                    <input type="text" readonly value="0" class="form-control"  name="avamount" id="avamount" required>
                                                </div>
                                            </div>
                                          
                                        </div>


                                        <div class="row mb-2 mt-3">
                                           <!-- end col-->
                                             <div class="col-sm-3">
                                                 <div class="text-sm">
                                                     <label>Amount Withdrawed</label>
                                                     <input type="text" class="form-control" onchange="fill()" value="0" min="0" required name="total_amount" id="total_amount">
                                                 </div>
                                             </div><!-- end col-->
                                             <div class="col-sm-3">
                                                 <div class="text-sm">
                                                     <label>Total balance</label>
                                                     <input type="text" readonly required class="form-control" name="ex_amount" id="ex_amount">
                                                 </div>
                                             </div>
                                             <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label>Date</label>
                                                    <input type="date" required class="form-control" value="{{date('Y-m-d')}}" name="date_added" id="date_added">
                                                </div>
                                            </div>

                                             <div class="col-sm-2">
                                                 <div class="text-sm-end pt-2">
                                                     <button type="submit" class="btn btn-primary mb-2 me-1 d-block">Save Withdraw</button>
                                                 </div>
                                             </div><!-- end col-->
                                          </div>
                                          <script>
                                            $(document).ready(function(){
                                            $('#cust_id').change(function() {

                                                var acct2 = $(this).val();

                                                document.getElementById('avamount').value =0;                                                
                                                document.getElementById("total_amount").value = 0;
                                                    document.getElementById("ex_amount").value = 0;
                                                if (acct2) {
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "{{ url('inventory/Deposits/getcust') }}?sup_id=" + acct2,
                                                        success: function(response) {

                                                            var len = 0;
                                                 if(response['data'] != null){
                                                   len = response['data'].length;
                                                 }

                                                 if(len > 0){
                                                   // Read data and create <option >
                                                   for(var i=0; i<len; i++){

                                                     var sup = response['data'][i].cust_name;
                                                    var balance =  response['data'][i].balance;


                                                    document.getElementById('avamount').value =balance;
                                                    document.getElementById('to_acct').value =sup;


                                                   }
                                                 }
                                                        }
                                                    });
                                                } else {
                                                document.getElementById('avamount').value =0;
                                                }
                                            });
                                        });
                                        </script>
                                         </form>

                                     </div>


                            </div>

                        </div>
                    </div>
                    <script>

                        function fill() {

                            var tamt1 = document.getElementById("avamount").value-0;
                            var tamt2 = document.getElementById("total_amount").value-0;

                             document.getElementById("ex_amount").value = tamt1-tamt2;

                        }

                    </script>


<script>


    function validateForm() {

     var q1 = document.getElementById("total_amount").value-0;
     var q3 = document.getElementById("avamount").value-0;
     var stm = 'Amount on hand is: ' +q1+ ' and  requested required is: ' +q3;
     var ex = document.getElementById("ex_amount").value;
        var bal = q1 + q2;


 if (q1 < 1) {
   swal('Error', 'The paid amount can not be less or equal to 0 !', 'warning');
    return false;
  }

  if (q1 < q3) {
   swal('Error', 'The withdraw amount can not be greater than customer amount !', 'warning');
    return false;
  }

  else if (isNaN(ex)){
   swal('Error', 'Invalid Amount !', 'warning');
    return false;
  }

  else if (ex=="Infinity"){
   swal('Error', 'Invalid Amount, please try again !', 'warning');
    return false;
  }
 

  else{
    return true;
  }

}
                   </script>

			</div>

 @endsection
