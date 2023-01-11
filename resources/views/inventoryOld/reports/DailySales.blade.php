
<!--  --------------------------------------------- -->

     <div class="tab-pane fade show" id="dailysales" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Daily Report form</h5>
            <form method="POST" action="{{url('inventory/report/view/dailysales')}}">
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



