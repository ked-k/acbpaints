            <style>
            
                            body {
                                font-size: 10px;
                                font-family:Calibri;
                            }
            
                            table {
                                font-size: 10px;
                                font-family:Calibri;
                            }
                            .center {
                                  display: block;
                                  margin-left: auto;
                                  margin-right: auto;
                                  width: 10px;
                                }
                                @media print {
  .noprint { display: none !important; }
            }
            
             </style>
 <table style="width:100%">
     <tr>
         <td>
       <header style="text-align:center">
                                    <div class="row">
                                            <!--<a href="javascript:;">-->
                                            <!--    <img src="{{url('assets/images/icons/mms.png')}}" alt="" class="center" />-->
                                            <!--</a>-->
                                       
                                            <h1 style="text-transform: uppercase; font-size: large; font-weight: 900;"> {{$appName}} </h1>
                                            <div> {{ $bizname }}</div>
                                            <div>{{$bizcontact}}</div>
                                            <div>{{$bizemail}}</div>
                                        
                                    </div>
                                </header>
                                </td>
                                </tr>
</table>
            <table style="width:100%">

                <tr>
                    <td align ="left">SALE ORDER NO</td>
                    <td align ="right">S01</td>
                </tr>
                <tr>
                    <td align ="left">SALE ORDER D/TIME</td>
                    <td align ="right">{{date('Y-M-d')}}</td>
                </tr>

                <tr>
                    <td align ="left">CUSTOMER</td>
                    <td align ="right">Ked</td>
                </tr>

            </table>
            <table style="width:100%">
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
                                                <td class="text-right">@money($value->sale_price)</td>
                                                <td class="text-right">@money($value->discount)</td>

                                                <td class="total">@money($value->itemamt) <input type="hidden" name="amount" value="{{ $value->itemamt}} "></td>
                                            </tr>
                                            @endforeach
                                                @endif
                                                <tfoot>
                                                    <tr style="display:none">
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
                                    <p style="text-align:center"><strong>Thank you for your business!</strong></p>
             <button  onclick="window.print();" type="button" class="btn btn-danger noprint"><i class="fa fa-file-pdf-o"></i> Print</button>
               <script>
      window.print();
      window.onmousemove = function() {
      window.close();}
     </script>
 <script>

function PrintElem() 
{
    Popup($html);
}

function Popup(data) 
{
    var myWindow = window.open('', 'Receipt', 'height=400,width=600');
    myWindow.document.write('<html><head><title>Receipt</title>');
    /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    myWindow.document.write('<style type="text/css"> *, html {margin:0;padding:0;} </style>');
    myWindow.document.write('</head><body>');
    myWindow.document.write(data);
    myWindow.document.write('</body></html>');
    myWindow.document.close(); // necessary for IE >= 10

    myWindow.onload=function(){ // necessary if the div contain images

        myWindow.focus(); // necessary for IE >= 10
        myWindow.print();
        myWindow.close();
    };
}
<script>
</script>
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