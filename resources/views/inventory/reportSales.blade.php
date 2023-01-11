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
                                    <div class="col-12">
                                        <h4 class="page-header text-center">
                                            <div>{{$bizname}}</div>
                                        </h4>
                                    <h4 class="page-header text-center">
                                    <i class="fas fa-globe"></i> SALES REPORT BETWEEN ({{$from}} AND {{$to}}) <br>
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
                                    <div class="col-sm-3 invoice-col">
                                    <address>
                                    <strong>Department: </strong>{{$dpt}}<br>
                                    </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-3 invoice-col">
                                        <address>
                                        <strong>Sub Units: </strong>{{$user}}<br>
                                        </address>
                                        </div>
                                    <!-- /.col -->
                                    <div class="col-sm-3 invoice-col">
                                        <address>
                                        <strong>Items: </strong>{{$item}}<br>
                                        </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            <address>
                                            <strong>Sale Type: </strong>{{$sale}}<br>
                                            </address>
                                            </div>
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
                                                <th>Item name</th>
                                                <th class="{{$disp}}">Department</th>
                                                <th class="{{$userDis}}">User</th>
                                                <th>Quantity</th>
                                                <th >Total amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($values)>0)
                                            @php($i=1)
                                            @foreach($values as $value)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td class="text-left">{{$value->item_name.'  '.$value->color.' ('.$value->uom_name.')'}}</td>
                                                <td class="{{$disp}}">{{$value->unit_name}}</td>
                                                <td class="{{$userDis}}">{{ $value->name}}</td>
                                                <td>{{ $value->qty}}</td>
                                                <td>@money($value->totalAmt) <input type="hidden" name="amount" value="{{ $value->totalAmt}} "></td>


                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>

                                    </table>

                                    </div>
                                    <p class="text-end mt-2">Total Amount: <strong><span id="totalamt"></span></strong></p>
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

<!--end page-wrapper-->
 @endsection
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
    document.getElementById('totalamt').innerHTML = num;

    }
    sumInputs();
    </script>
