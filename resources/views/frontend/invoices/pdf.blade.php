<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice_number }}</title>

    <style>
        body {
            font-family: 'almarai', sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            font-size: 9px;
            line-height: 24px;
            font-family: 'almarai', sans-serif;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: right;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td {
            text-align: left;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 30px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: 'almarai', sans-serif;
        }
        .rtl table {
            text-align: right;
        }
        .rtl table tr td {
            text-align: right;
        }
        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="6">
                <table>
                    <tr>
                        <td width="65%" class="title">
                            <img src="{{ asset('frontend/images/logo.png') }}" style="width:100px; max-width:100px;">
                        </td>

                        <td width="35%">
                            Serial: {{ $invoice_number }}<br>
                            Date: {{ $invoice_date }}<br>
                            Print_date: {{ Carbon\Carbon::now()->format('Y-m-d') }}<br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><h2>Invoice title</h2></td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="6">
                <table>
                    <tr>
                        <td width="50%">
                            <h2>Seller</h2>
                            Seller name<br>
                            <span dir="ltr">Seller phone</span><br>
                            Seller vat<br>
                            Seller address
                        </td>

                        <td width="50%">
                            <h2>Buyer</h2>
                            @foreach($customer as $key => $val)
                                {{ $key }}: {{ $val }}<br>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td></td>
            <td>Product name</td>
            <td>Unit</td>
            <td>Quantity</td>
            <td>Unit price</td>
            <td>Sub total</td>
        </tr>

        @foreach($items as $item)
            <tr class="item {{ $loop->last ? 'last' : '' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['product_name'] }}</td>
                <td>{{ $item['unit'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>SAR {{ $item['unit_price'] }}</td>
                <td>SAR {{ $item['row_sub_total'] }}</td>
            </tr>
        @endforeach

        <tr class="total">
            <td colspan="4"></td>
            <td>Sub_total</td>
            <td>SAR {{ $sub_total }}</td>
        </tr>

        <tr class="total">
            <td colspan="4"></td>
            <td>Discount</td>
            <td>SAR {{ $discount }}</td>
        </tr>
        <tr class="total">
            <td colspan="4"></td>
            <td>Vat</td>
            <td>SAR {{ $vat_value }}</td>
        </tr>
        <tr class="total">
            <td colspan="4"></td>
            <td>Shipping</td>
            <td>SAR {{ $shipping }}</td>
        </tr>
        <tr class="total">
            <td colspan="4"></td>
            <td>Total_due</td>
            <td>SAR {{ $total_due }}</td>
        </tr>
    </table>
</div>
</body>
</html>
