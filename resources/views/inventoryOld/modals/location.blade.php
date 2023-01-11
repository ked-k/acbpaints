<div class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ url('inventory/location/add') }}" method="POST">
            @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">

                        <input class="form-control form-control-md mb-3" name="name" type="text" placeholder="location name" aria-label=".form-control-sm example">
                        <input class="form-control form-control-md mb-3" name="region" type="text" placeholder="location region" aria-label=".form-control-sm example">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save location</button>
            </div>
        </div>
    </form>
    </div>
</div>
