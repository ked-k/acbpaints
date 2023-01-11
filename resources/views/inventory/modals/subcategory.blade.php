                                        <div class="modal fade" id="subCategoryModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-md">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Create a new category</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
                                                    <form action="{{ url('inventory/subunits/add') }}" method="POST">
                                                        <div class="modal-body">

                                                                @csrf

                                                                <div class="row">
                                                                    <div class="col-md-12">


                                                                        <div class="mb-3">
                                                                            <label for="CategoryName" class="form-label">SubCategory Name</label>
                                                                            <input type="text" id="CategoryName" name="subunit_name" class="form-control"  required>
                                                                        </div>


                                                                        <div class="mb-3">
                                                                            <label class="form-label">Select category</label>
                                                                            <div class="input-group">
                                                                                <select class="single-select form-select" name="unit_name">
                                                                                    <option value="">Select a Category</option>
                                                                                    @if(count($valueUnites)>0)
                                                                                @foreach($valueUnites as $valueUnit)
                                                                                    <option value="{{ $valueUnit->id }}">{{ $valueUnit->unit_name}}</option>
                                                                                @endforeach
                                                                                @endif
                                                                                </select>
                                                                                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#categoryModal"><i class='bx bx-add'></i>New
                                                                                </button>
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
