<div class="modal fade" id="ExpenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a new Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('inventory/expenditures/add') }}" method="POST">
                <div class="modal-body">

                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="reff_number" class="form-label">Refference No.</label>
                                    <input type="text" id="reff_number" value="EXP{{mt_rand(1000, 9999).time()}}" name="reff_number" class="form-control"  required>
                                </div>

                                <div class="mb-3">
                                    <label for="exp_amount" class="form-label">Amount</label>
                                    <input type="text" id="exp_amount" name="exp_amount" class="form-control" value="{{old('exp_amount')}}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" class="form-control"  id="type">
                                        <option selected value="Miscellaneous">Miscellaneous expenses </option>
                                        <option value="Rent">Rent expense </option>
                                        <option value="Finance cost">Finance cost </option>
                                        <option value="Taxation">Taxation expense</option>
                                        <option value="Communication">Communication expense </option>
                                        <option value="Utilities costs">Cost of utilities </option>
                                        <option value="Depreciation">Depreciation expense </option>
                                        <option value="Stationery">Printing and stationery expense </option>
                                        <option value="Goods cost">Cost of goods sold </option>
                                        <option value="Selling and distribution">Selling and distribution expenses </option>
                                        <option value="Operational">Operating, general and administrative expenses </option>
                                        <option value="Salaries">Salaries, wages, and benefits </option>
                                        <option value="Travel">Staff traveling expense </option>
                                        <option value="Repair and Maintenance">Repair and maintenance expense </option>
                                        <option value="Insurance"> Insurance cost </option>
                                        <option value="Legal">Legal and professional charges </option>

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                   <textarea class="form-control" name="description" id="description" cols="30" rows="3">{{old('description')}}</textarea>
                                </div>

                                    <div class="mb-3">
                                    <div class="text-sm">
                                    <label>Date</label>
                                    <input type="date" required class="form-control" value="{{date('Y-m-d')}}" name="date_added" id="date_added">
                                    </div>
                                    </div>
                            </div> <!-- end col -->

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
