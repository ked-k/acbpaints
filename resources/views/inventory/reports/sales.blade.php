
<!--  --------------------------------------------- -->

     <div class="tab-pane fade show" id="sales" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Sales Report form</h5>
            <form method="POST" action="{{url('inventory/report/view/sales')}}">
                @csrf
                    <div class="row">
                    <div class="col-md-6 ">
                        <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from" value="{{date('Y-m-d')}}" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                            <div class="form-group">
                            <label>To</label>
                            <input type="date" name="to" class="form-control" value="{{date('Y-m-d')}}" required="">
                            </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group">
                            <label for="subCategory">Users</label>

                            <select name="user" id="user" class="single-select form-select">
                                <option selected value="0" selected>All users</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group">
                        <label>Select Department/category</label>
                        <select class="single-select form-select" name="unit_id" id="unit_id" required>
                            <option selected value="0">All</option>
                            @foreach($valueUnits as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->unit_name}}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <div class="form-group">
                        <label>Sale Type</label>
                        <select class="single-select form-select" name="saleType" required>
                            <option selected value="0">All</option>
                            <option value="Msale">Machine sale</option>
                            <option value="Tsale">Table sale</option>
                            <option value="cash">Store sale</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div>
                        <label>Select Item</label>
                        <select class="single-select form-select" name="items_id" id="items_id">
                            <option selected value="0">All</option>
                            @foreach($items as $item)
                            <option value="{{$item->item_id}}">{{$item->item_name.' ('.$item->uom_name.')'  }}</option>
                            @endforeach

                        </select>
                        </div>
                     </div>

                    </div>
                    <button type="submit" class="btn btn-primary mt-2 text-sm-end"><i class="fa fa-file"></i> Show report</button>
            </form>
    </div>
    <script>
        $(document).ready(function(){
        $('#unit_id').change(function() {

            var dpt = $(this).val();

            $("#items_id").empty();
            $("#items_id").append('<option value="0">All depart items</option>');

            if (dpt) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('inventory/getDptitemData') }}?dpt_id=" + dpt,
                    success: function(response) {

                        var len = 0;
             if(response['data'] != null){
               len = response['data'].length;
             }

             if(len > 0){
               // Read data and create <option >
               for(var i=0; i<len; i++){

                 var itemid = response['data'][i].pid;
                var itemName =  response['data'][i]. itemname;
                var options = "<option value='"+itemid+"'>"+itemName+"</option>";
                $("#items_id").append(options);

               }
             }
                    }
                });
            } else {
                $("#items_id").empty();
            $("#items_id").append('<option value="0">All depart items</option>');
            }
        });
    });
    </script>


