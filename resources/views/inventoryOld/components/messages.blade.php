@if (count($errors)>0)

@foreach ($errors->all() as $error)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong>{{$error}}</strong>

</div>

@endforeach

@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible  border-0 fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong>{{session('success')}}</strong>
	</button>
</div>
@endif



@if (session('error'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong>{{session('error')}}</strong>
</div>
@endif
