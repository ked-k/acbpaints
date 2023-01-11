@extends('inventory.layouts.tableLayout')
@section('title',''.$appName.' | print')
@section('content')
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Invoice</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row">


                <div class="col-xl-12">
                    <div class="">
                                    <div class="card-body">
                                    <div class="row">

                                    <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                    <section class="invoice">
                                    <!-- title row -->
                                    <div class="row">
                                        <div class="col-md-12"> <img  src="{{ url('assets/images/acb.png')}}" style="width:75%;  display: block; margin-left: auto; margin-right: auto; "></div>
                                    <div class="col-12">
                                        <h4 class="page-header text-center">
                                            <div>{{$bizname}}</div>
                                        </h4>
                                    <h4 class="page-header text-center">
                                    <i class="fas fa-globe"></i> DAILY SALES REPORT BETWEEN ({{$from}} AND {{$to}}) <br>
                                    @if($dpt != 'All'){
                                       {{$dpt}}
                                    }
                                    @endif

                                    </h4>
                                    </div>
                                    <!-- /.col -->
                                    </div>
                                    <!-- info row -->
                                    <div class="row invoice-info">

                                    <!-- /.col -->

                                    <!-- /.col -->

                                    <!-- /.col -->
                                    </div>
                                    <!-- /.row -->

                                    <!-- Table row -->
                                    <div class="row">
                                    <h4 class="header-title text-center mb-3">Items</h4>
                                    <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Item name</th>z
                                                <th>Quantity</th>
                                                <th>Cost price</th>
                                                <th>Sale price</th>
                                                <th class="text-end">Total profit</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($values)>0)
                                            @php($i=1)
                                            @foreach($values as $value)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td class="text-left">{{$value->item_name.'  '.$value->color.' ('.$value->uom_name.')'}}</td>
                                                <td>{{ $value->qty}}</td>
                                                <td class="text-end">@money( $value->qty*$value->cost_price) @php($x=$value->qty*$value->cost_price)</td>
                                                <td class="text-end">@money($value->qty*$value->price)  @php($y=$value->qty*$value->price)</td>
                                                <td class="text-end">@php($z=$y-$x)
                                                    @money($z) <input type="hidden" name="amount" value="{{$z}} "></td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>

                                    </table>

                                    </div>
                                    <p class="text-end text-primary mt-4">Total profits: <strong><span id="totalamount"></span></strong></p>
                                    <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                    <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-4">
                                    <p >Processed by: <strong>{{auth()->user()->name}}</strong></p>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-4">
                                    <p >Date processed: <strong>{{date('Y-m-d')}}</strong></p>

                                    </div>
                                    <div class="col-2">
                                    <button onclick="window.print();"  class="btn btn-default"><i class="mdi mdi-printer-check"></i> Print</button>

                                    </div>

                                    <!-- /.col -->
                                    </div>

                                    <!-- /.row -->
                                    </section>
                                    </div> <!-- tab-content -->
                                    </div> <!-- end #rootwizard-->
                                    </div>

            </div>
        </div>
    </div>
    <!--end page-content-wrapper-->
    <script type="text/javascript">

        window.sumInputs = function() {
            var inputs = document.getElementsByName('amount'),

                sum = 0;

            for(var i=0; i<inputs.length; i++) {
                var ip = inputs[i];

                if (ip.name && ip.name.indexOf("total") < 0) {
                    sum += parseFloat(ip.value) || 0;
                }

            }


            var ked = sum;
          var num = 'UGX: ' + ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        document.getElementById('totalamount').innerHTML = num;

        }
        sumInputs();
        </script>
<!--end page-wrapper-->
 @endsection

