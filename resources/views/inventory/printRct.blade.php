
    <!--page-content-wrapper-->
    
    <style>
            
        body {
            font-size: 12px;
            font-family:Calibri;
        }

        table {
            font-size: 11px;
            font-family:Calibri;
        }
        .center {
              display: block;
              margin-left: auto;
              margin-right: auto;
              width: 10px;
            }
        .nodis{
            display: none !important; 
        }
            @media  print {
.noprint { display: none !important; }
.nodis { display: block !important; }
}

</style>
<div class="">
<table style="width:100%">
    <tr>
        <td>
      <header style="text-align:center">
                                   <div class="row">                                      
                                           <h1 style="font-size:19.0pt; text-transform: uppercase; font-size: large; font-weight: 900;"> ALEX Paints </h1>
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
        <td align ="left">S01</td>
    </tr>
    <tr>
        <td align ="left">SALE ORDER D/TIME</td>
        <td align ="left">2022-Mar-04</td>
    </tr>

    <tr>
        <td align ="left">CUSTOMER</td>
        <td align ="left">Ked</td>
    </tr>

</table>
<table style="width: 100%">
    <thead>
        <tr>
            <th class="text-left">Item</th>
            <th class="text-right">Qty</th>
            <th class="text-right">Price</th>
            {{-- <th class="text-right">Dis</th> --}}
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @if(count($values)>0)
        @php($i=1)
        @foreach($values as $value)

        <tr >
            <td style="border-top: 1px dashed #0e0d0d" class="text-left">{{$value->item_name.'  '.$value->color.' ('.$value->uom_name.')'}}</td>
            <td style="border-top: 1px dashed #0e0d0d" class="text-right">{{ $value->qty_given}} <input  type="hidden" name="quantity[]" value="{{$value->qty_given}}"></td>
            <td style="border-top: 1px dashed #0e0d0d" class="text-right">@money($value->sale_price)</td>
            {{-- <td class="text-right">@money($value->discount)</td> --}}

            <td style="border-top: 1px dashed #0e0d0d" class="total">@money($value->itemamt) <input type="hidden" name="amount" value="{{ $value->itemamt}} "></td>
            
        </tr>
        
        @endforeach
            @endif
            <tfoot>
               

                <tr>
                    <td ></td>
                    <td style="border-top: 1px dashed #0e0d0d" colspan="2">GRAND TOTAL</td>
                    <td style="border-top: 1px dashed #0e0d0d"><p id="grandtotal"></p></td>
                </tr>
            </tfoot>
</table>
                        <p style="text-align:center"><strong>Thank you for your business!</strong></p>
                    </div>
 <button  onclick="window.print();" type="button" class="btn btn-danger noprint"><i class="fa fa-file-pdf-o"></i> Print</button>
   <script>
window.print();
window.onmousemove = function() {
window.close();}
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
          var num =  ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      
        document.getElementById('grandtotal').innerHTML = num;

        }
        sumInputs();
        </script>
<!--end page-wrapper-->

