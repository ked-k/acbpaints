@extends('inventory.layouts.formLayout')
@section('title', 'Items')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Items</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Items</li>
							</ol>
						</nav>
					</div>

				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">New item</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-body p-4">
                                    <h5 class="card-title">Add New Product</h5>
                                    <hr/>
                                    <form method="POST" action="{{ url('inventory/item/add') }}"  name="myForm"  class="needs-validation"  onsubmit="return validateForm()" >
                                        @csrf
                                     <div class="form-body mt-4 text-left">
                                          <div class="row">
                                              <div class="col-lg-6">
                                                  <div class="border border-3 p-4 rounded">
                                                  <div class="row g-3">
                                                      <div class="mb-3">
                                                          <label for="inputProductTitle" class="form-label">Product Title</label>
                                                          <input type="text" class="form-control" id="inputProductTitle" name="item_name" required placeholder="Enter product title">
                                                      </div>
                                                      <div class="col-12">
                                                        <label for="inputProductTags" class="form-label">Product barcode</label>
                                                        <input type="text" class="form-control" id="inputProductTags" name="item_barcode" placeholder="Enter Product Tags">
                                                    </div>
                                                      <div class="col-md-6">
                                                          <label for="inputPrice" class="form-label">Cost Price</label>
                                                          <input type="text" onchange="mymargin()" name="cost_price" class="form-control" required id="cost_price" placeholder="00.00">
                                                      </div>
                                                      <div class="col-md-6">
                                                          <label for="inputCompareatprice" class="form-label">Sale Price</label>
                                                          <input type="text" onchange="mymargin2()" name="sale_price" class="form-control" required id="sale_price" placeholder="00.00">
                                                      </div>
                                                      <div class="col-md-6">
                                                          <label for="inputCostPerPrice" class="form-label">Margin</label>
                                                          <input type="text" readonly required name="margin" class="form-control" id="margin" placeholder="00.00">
                                                      </div>
                                                      <div class="col-md-6">
                                                          <label for="inputStarPoints" class="form-label">Model No</label>
                                                          <input type="text" name="model_no" class="form-control text-uppercase" id="inputStarPoints" placeholder="00.00">
                                                      </div>
                                                      <div class="col-12">
                                                          <div class="mb-3">
                                                              <label class="form-label">Select category</label>
                                                              <div class="input-group">
                                                                  <select class="single-select form-select" name="unit_id" id="unit" required>
                                                                    <option value="" selected disabled>Select Category</option>
                                                                    @foreach($valueUnites as $unit)
                                                                    <option value="{{ $unit->id }}">{{ $unit->unit_name}}</option>
                                                                    @endforeach
                                                                  </select>
                                                                  <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#categoryModal"><i class='bx bx-add'></i>New
                                                                  </button>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-12">
                                                            <label for="subCategory" class="form-label">Subcategory</label>
                                                            <div class="input-group">
                                                                <select name="subunit_id" id="subunit" class="single-select form-select"></select>

                                                                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#subCategoryModal"><i class='bx bx-add'></i>New
                                                                </button>
                                                            </div>
                                                      </div>
                                                      <script>
                                                          $.ajaxSetup({
                                                            headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                            });
                                                        $(document).ready(function(){
                                                        $('#unit').change(function() {

                                                            var unitID = $(this).val();

                                                            if (unitID) {

                                                                $.ajax({
                                                                    type: "GET",
                                                                    url: "{{ url('inventory/getSubUnits') }}?unit_id=" + unitID,
                                                                    success: function(res) {

                                                                        if (res) {

                                                                            $("#subunit").empty();
                                                                            $("#subunit").append('<option>Select subcategory</option>');
                                                                            $.each(res, function(key, value) {
                                                                                $("#subunit").append('<option value="' + key + '">' + value +
                                                                                    '</option>');
                                                                            });

                                                                        } else {

                                                                            $("#subunit").empty();
                                                                        }
                                                                    }
                                                                });
                                                            } else {

                                                                $("#subunit").empty();

                                                            }
                                                        });
                                                    });
                                                    </script>

                                                  </div>
                                              </div>
                                              </div>
                                              <div class="col-lg-6">
                                              <div class="border border-3 p-4 rounded">
                                                  <div class="mb-3">
                                                      <label for="color" class="form-label text-left">Product color</label>
                                                      <input type="text" name="color" required class="form-control" id="color" placeholder="Enter product title">
                                                  </div>
                                                  <div class="mb-3">
                                                    <label for="uom" class="form-label">UOM</label>
                                                    <div class="input-group">
                                                      <select class="single-select form-select" id="uom_id" name="uom_id" required>
                                                          <option value="">Select</option>
                                                          @if(count($uoms)>0)
                                                          @foreach($uoms as $uom)
                                                              <option value="{{ $uom->id }}">{{ $uom->uom_name}}</option>
                                                          @endforeach
                                                          @endif
                                                      </select>
                                                      <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#UomModal"><i class='bx bx-add'></i>New
                                                      </button>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="supplier" class="form-label">Supplier</label>
                                                  <div class="input-group">
                                                    <select class="single-select form-select" id="supplier" required name="supplier_id">
                                                      <option value="">Select Supplier</option>
                                                      @if(count($suppliers)>0)
                                                      @foreach($suppliers as $supplier)
                                                          <option value="{{ $supplier->id }}">{{ $supplier->sup_name}}</option>
                                                      @endforeach
                                                      @endif
                                                    </select>
                                                    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#SupplierModal"><i class='bx bx-add'></i>New
                                                    </button>
                                                  </div>
                                              </div>
                                              <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                            </div>
                                              <label for="code" class="form-label">Price code</label>
                                              <div class="text-center">
                                                <input type="hidden" class="form-control" value="{{$syscode}}" required name="syscode">
                                                <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($syscode, 'C39',1,55,array(0,0,0), true)}}" alt="barcode" /><br><br>

                                            </div>


                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary">Save Product</button>
                                                    </div>
                                                </div>
                                                  </div>
                                              </div>

                                          </div><!--end row-->
                                     </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>


                    @include("inventory.modals.supplier")
                    @include("inventory.modals.category")
                    @include("inventory.modals.subcategory")
                    @include("inventory.modals.uom")
                 <script>

                        function validateForm() {
                        var x = document.forms["myForm"]["cost_price"].value-0;
                        var y = document.forms["myForm"]["sale_price"].value-0;
                        var z  = document.forms["myForm"]["margin"].value;
                      if (x > y) {

                        swal('Eroor ', 'Product sale price must be greater than your cost price!', 'error');
                        return false;
                      }
                      else if (y > x) {
                     swal('Good Job', 'Your details will be submitted!', 'success');

                        return true;
                      }

                        else if (x === y){

                        swal('Error', 'Product sale price must be greater than your cost price!', 'warning');
                        return false;
                      }

                       else if (z < 0) {
                       swal('Error', 'Product margin is too low!', 'warning');
                        return false;
                      }
                      else if (z =="") {
                       swal('Error', 'Margun can not be null!', 'warning');
                        return false;
                      }

                    }
              </script>

                            <script type="text/javascript">
                                function mymargin(){
                                var val1 = document.getElementById('cost_price').value-0;
                                document.getElementById('sale_price').value = val1;
                                var val2 = document.getElementById('sale_price').value-0;
                                var val3 = val2 - val1;
                                var val4 = val3/val2;
                                var mymgn = val4*100;
                                document.getElementById('margin').value = mymgn.toFixed(2)+'%';
                            }

                                 function mymargin2(){
                                var val1 = document.getElementById('cost_price').value-0;
                                var val2 = document.getElementById('sale_price').value-0;
                                var val3 = val2 - val1;
                                var val4 = val3/val2;
                                var mymgn = val4*100;
                                document.getElementById('margin').value = mymgn.toFixed(2);
                            }
                            </script>
			</div>
 @endsection
