
<!--  --------------------------------------------- -->

     <div class="tab-pane fade show active" id="profitMargin" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Store Profit margin Report form</h5>
            <form method="POST" action="{{url('inventory/report/view/profitMargin')}}">
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

                    <div class="col-md-8 mt-2">
                        <div class="form-group">
                        <label>Items</label>
                        <select class="single-select form-select" name="items_id" required>

                            <option selected value="0">All</option>
                            @foreach($items as $item)
                            <option value="{{$item->item_id}}">{{$item->item_name.' ('.$item->uom_name.')'  }}</option>
                            @endforeach
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <button type="submit" class="btn btn-primary mt-2 text-sm-end"><i class="fa fa-file"></i> Show report</button>
                     </div>

                    </div>

            </form>
    </div>



