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
            <div class="card">
                <div class="card-body">
                    <div id="invoice">

                        <div class="invoice overflow-auto">
                            <div style="min-width: 600px">
                                <header>
                                    <div class="row">
                                        <div class="col">
                                            <a href="javascript:;">
                                                <img src="{{url('assets/images/icons/mms.png')}}" width="140" alt="" />
                                            </a>
                                        </div>
                                        <div class="col company-details">
                                            <h2 class="name">
                                            {{$appName}}
                                    </h2>
                                            <div> {{ $bizname }}</div>
                                            <div>{{$bizcontact}}</div>
                                            <div>{{$bizemail}}</div>
                                        </div>
                                    </div>
                                </header>
                                <main>
                                    <div class="row contacts">
                                        @if(count($custs)>0)
                                        @foreach($custs as $cust)
                                        <div class="col invoice-to">
                                            <div class="text-gray-light">INVOICE TO:</div>
                                            <h2 class="to">{{$cust->cust_name != '' ? $cust->cust_name : 'NA'}}</h2>
                                            <div class="address">{{$cust->address != '' ? $cust->address  : 'NA' }}</div>
                                            <div class="email"><a href="mailto:{{$cust->email}}">{{$cust->email != '' ? $cust->email  : 'NA'}}</a>
                                            </div>
                                        </div>
                                      @endforeach
                                        @else
                                        <div class="col invoice-to">
                                            <div class="text-gray-light">INVOICE TO:</div>
                                            <h2 class="to">NA</h2>
                                            <div class="address">NA</div>
                                            <div class="email"><a href="mailto:ked.ripontechug.com">NA</a>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col invoice-details">
                                            <h1 class="invoice-id">INVOICE 3-2-1</h1>
                                            <div class="date">Date of Invoice: {{date('Y-M-d')}}</div>

                                        </div>
                                    </div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-left">Item</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-right">Price</th>
                                                <th class="text-right">Discount</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($values)>0)
                                            @php($i=1)
                                            @foreach($values as $value)

                                            <tr>
                                                <td class="no">{{$i++}}</td>
                                                <td class="text-left">{{$value->item_name.'  '.$value->color.' ('.$value->uom_name.')'}}</td>
                                                <td class="text-right">{{ $value->qty_given}} <input type="hidden" name="quantity[]" value="{{$value->qty_given}}"></td>
                                                <td class="text-right">@money($value->sprice)</td>
                                                <td class="text-right">@money($value->discount)</td>

                                                <td class="total">@money($value->itemamt) <input type="hidden" name="amount" value="{{ $value->itemamt}} "></td>
                                            </tr>
                                            @endforeach
                                                @endif
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td colspan="2">SUBTOTAL</td>
                                                        <td><p id="subtotal"></p></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td colspan="2">GRAND TOTAL</td>
                                                        <td><p id="grandtotal"></p></td>
                                                    </tr>
                                                </tfoot>
                                    </table>
                                    <div class="thanks">Thank you!</div>
                                    <div class="notices">
                                        <div>NOTICE:</div>
                                        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                                    </div>
                                </main>
                                <footer>Invoice was created on a computer and is valid without the signature and seal.</footer>
                            </div>
                            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                            <div></div>
                        </div>
                        <div class="toolbar hidden-print">
                            <div class="text-right">
                                <a target="_blank" href="{{url('inventory/print/reciept/'.$id)}}" class="btn btn-dark"><i class="fa fa-print"></i> Print</a>
                              
                            </div>
                            <hr/>
                        </div>
                    </div>
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
        document.getElementById('subtotal').innerHTML = num;
        document.getElementById('grandtotal').innerHTML = num;

        }
        sumInputs();
        </script>
<!--end page-wrapper-->
 @endsection