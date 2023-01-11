
<!doctype html>
<html lang="en">
    @php
    $appName="Rpos";
    $bizcontact="+256-704083209";
    $bizlocation="Makerere Kampala";
    $bizname="Ripon Technologies Ug Ltd";
    $email="info@ripontechug.com";
    View::share($appName);
 @endphp

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('assets/images/favicon-32x32.png')}}') }}" type="image/png" />
	<!--plugins-->
	{{-- <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" /> --}}
	{{-- <!-- loader-->
	<link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('assets/js/pace.min.js') }}"></script> --}}
	<!-- Bootstrap CSS -->
	{{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" /> --}}
    <title>@yield('title')</title>
</head>

<body class="">
    {{-- @if(Session::get('branchdata') =="" )
    <script type="text/javascript">
        window.location = "{{ url('inventory/select/location') }}";
       </script>
    @endif --}}
{{-- @php
    if(!isset($_SESSION['locationName'])){
	header('inventory/select/location');
}
@endphp --}}
@if(empty(Session::get('branch')))
<script type="text/javascript">
    window.location = "{{ url('inventory/select/location') }}";
   </script>
 @endif
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
        @include("inventory.components.sidebar")
		<!--end sidebar wrapper -->
		<!--start header -->
        @include("inventory.components.header")
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
            @include("inventory.components.messages")
            @yield('content')
		</div>
		<!--end page wrapper -->
		<!--start overlay-->

		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->

	</div>
	<!--end wrapper-->
	<!--start switcher-->

	<!--end switcher-->
	<!-- Bootstrap JS -->
	{{-- <script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{ asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/sweetalert/sweetalert.min.js')}}"></script> --}}
	
	
</body>

</html>
