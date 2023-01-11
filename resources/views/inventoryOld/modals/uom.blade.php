                                        <div class="modal fade" id="UomModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-md">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Create a new Unit of measurement</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
                                                    <form action="{{ url('inventory/uom/add') }}" method="POST">
                                                        <div class="modal-body">

                                                                @csrf

                                                                <div class="row">
                                                                    <div class="col-md-12">


                                                                        <div class="mb-3">
                                                                            <label for="uom_name" class="form-label">UOM Name</label>
                                                                            <input type="text" id="uom_name" name="uom_name" class="form-control" >
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
