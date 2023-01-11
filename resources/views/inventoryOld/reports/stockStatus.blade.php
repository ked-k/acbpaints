
<!--  --------------------------------------------- -->

     <div class="tab-pane fade show active" id="stockstatus" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Stock status Report form</h5>
            <form method="POST" action="{{url('inventory/report/view/stock')}}">
                @csrf
                    <div class="row">
                    <div class="col-md-6 d-none">
                        <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from" value="{{date('Y-m-d')}}" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-6 d-none">
                            <div class="form-group">
                            <label>To</label>
                            <input type="date" name="to" class="form-control" value="{{date('Y-m-d')}}" required="">
                            </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <div class="form-group">
                        <label>Select Department/category</label>
                        <select id="department_id" class="form-control myselect" name="department_id" required>
                            <option selected value="0" selected>All Units</option>

                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name}}</option>
                        @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="form-group">
                            <label for="subCategory">Users</label>

                            <select name="inv_subunit_id" id="inv_subunit_id" class="form-control myselect">
                                <option selected value="0" selected>All users</option>
                                @foreach($subunits as $subunit)
                                <option value="{{$subunit->id}}">{{$subunit->subunit_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div>
                        <label>Select Item</label>
                        <select class="form-control myselect" name="inv_items_id" id="inv_items_id">
                            <option selected value="0">All</option>
                            @foreach($items as $item)
                            <option value="{{$item->item_id}}">{{$item->item_name.' ('.$item->uom_name.')  ->['.$item->name.']'  }}</option>
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
        $('#department_id').change(function() {

            var itemID = $(this).val();
            $("#inv_subunit_id").empty();
            $("#inv_subunit_id").append('<option value="0">All subcategories</option>');

            $("#inv_items_id").empty();
            $("#inv_items_id").append('<option value="0">All items</option>');

            if (itemID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('inventory/getDptData') }}?dpt_id=" + itemID,
                    success: function(response) {

                        var len = 0;
             if(response['itemData1'] != null){
               len = response['itemData1'].length;
             }

             if(len > 0){
               // Read data and create <option >
               for(var i=0; i<len; i++){
                var id =  response['itemData1'][i].id;
                var subunit_name =  response['itemData1'][i].subunit_name;

                var optionsub = "<option value='"+id+"'>"+subunit_name+"</option>";

                $("#inv_subunit_id").append(optionsub);
               }
             }

             var len2 = 0;
             if(response['itemData'] != null){
               len2 = response['itemData'].length;
             }

             if(len2 > 0){
               // Read data and create <option >
               for(var i=0; i<len2; i++){
                var item_id =  response['itemData'][i].item_id;
                var item_name =  response['itemData'][i].item_name;

                var optionitem = "<option value='"+item_id+"'>"+item_name+"</option>";

                $("#inv_items_id").append(optionitem);
               }
             }
                    }
                });
            } else {

            $("#inv_subunit_id").empty();
            $("#inv_subunit_id").append('<option value="0">All subcategories</option>');

            $("#inv_items_id").empty();
            $("#inv_items_id").append('<option value="0">All items</option>');


            }
        });
    });
    </script>

{{-- <script>
    $(document).ready(function(){
    $('#inv_subunit_id').change(function() {

        var SubCatID = $(this).val();

        $("#inv_items_id").empty();
        $("#inv_items_id").append('<option value="0">All items</option>');

        if (SubCatID) {
            $.ajax({
                type: "GET",
                url: "{{ url('inventory/getSubDptData') }}?sub_id=" + SubCatID,
                success: function(response) {

                    var len = 0;
         if(response['item'] != null){
           len = response['item'].length;
         }


         var len2 = 0;
         if(response['item'] != null){
           len2 = response['item'].length;
         }

         if(len2 > 0){
           // Read data and create <option >
           for(var i=0; i<len2; i++){
            var item_id =  response['item'][i].item_id;
            var item_name =  response['item'][i].item_name;

            var optionitem = "<option value='"+item_id+"'>"+item_name+"</option>";

            $("#inv_items_id").append(optionitem);
           }
         }
                }
            });
        } else {


        $("#inv_items_id").empty();
        $("#inv_items_id").append('<option value="0">All items</option>');


        }
    });
});

</script> --}}
