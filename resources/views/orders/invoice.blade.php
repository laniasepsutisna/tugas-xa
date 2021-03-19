<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Invoice Order</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="{{ asset('custom.css')  }}">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
</head>
<body>

<div id="invoice">
    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
            <button class="btn btn-primary"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="#">
                            <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" data-holder-rendered="true" width="100px"/>
                        </a>
                    </div>
                    <div class="col company-details">
                        <h2 class="name text-primary">
                            APPSTACK ORDER
                        </h2>
                        <div>Jl. Penghulu No. 22 Jakarta Timur, Jakarta</div>
                        <div>021-0220-22-01</div>
                        <div>admin@appstack.com</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="to">{{  $order['customer_name'] }}</h2>
                        <div class="address">{{ $order['default_shipping_address'] }}, {{ $order['country'] }} {{ $order['phone'] }}</div>
                        <div class="email"><a href="to:{{ $order['email'] }}">{{ $order['email'] }}</a></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE</h1>
                        <div class="date"><i>{{  $order['id'] }}</i></div>
                        <div class="date">Date of Invoice: {{ $order['order_date']  }}</div>
                        <div class="date">Due Date: {{ $order['order_date']  }}</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-left">PRODUCT NAME</th>
                        <th class="text-right">PRICE</th>
                        <th class="text-right">QUANTITY</th>
                        <th class="text-right">HEIGHT x WIDTH</th>
                        <th class="text-right">RATING</th>
                        <th class="text-right">TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order_detail as $item)
                        <tr>
                            <td class="no">{{ $loop->iteration  }}</td>
                            <td class="text-left"><h3>{{ $item['product_name'] }}</h3>{{ $item['description'] }}</td>
                            <td class="unit text-center">Rp.{{ number_format($item['price']) }}</td>
                            <td class="qty text-center">{{ $item['quantity'] }} Pcs</td>
                            <td class="height text-center">{{ $item['height'] }} x {{ $item['width'] }}</td>
                            <td class="rating text-center">{{ $item['rating'] }}</td>
                            <td class="total text-right">Rp.{{ number_format($a[]=$item['price']*$item['quantity']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="3">SUBTOTAL</td>
                        <td>Rp.{{ $st = number_format(array_sum($a))  }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="3">PPN 10%</td>
                        <td>Rp.{{ $ppn = number_format(10/100 * array_sum($a)) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="3">GRAND TOTAL</td>
                        <td>{{ number_format(array_sum($a) + 10/100 * array_sum($a)) }}</td>
                    </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div>
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>

<script>
    $('#printInvoice').click(function(){
        Popup($('.invoice')[0].outerHTML);
        function Popup(data)
        {
            window.print();
            return true;
        }
    });
</script>

</body>
</html>
