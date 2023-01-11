
<!--  --------------------------------------------- -->

     <div class="tab-pane fade" id="demand" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Demand Report form</h5>
            <form method="POST" action="">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from" value="{{date('Y-m-d')}}" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                            <label>To</label>
                            <input type="date" name="to" class="form-control" value="{{date('Y-m-d')}}" required="">
                            </div>
                    </div>
                        <div class="col-md-12">
                            <div >
                            <label>Select Product</label>
                            <select class="form-control select2" name="product" style="width:100%;">
                            <option value="">All products</option>

                            </select>
                            </div>
                         </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Select User</label>
                        <select class="form-control select2" name="user" style="width:100%;">
                        <option value="">All users</option>

                        </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Shop type</label>
                        <select  class="form-control" name="shop">
                                    <option value="">All</option>
                        </select>
                        </div>
                    </div>

                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-file"></i> Show report</button>
            </form>
    </div>
