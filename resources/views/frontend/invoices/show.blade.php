@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h2>Invoice {{ $invoice->invoice_number }}</h2>
                    <a href="{{ route('invoices.index') }}" class="btn btn-primary ml-auto"><i class="fa fa-home"></i> Back to invoice</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Customer name</th>
                                <td>{{ $invoice->customer_name }}</td>
                                <th>Customer email</th>
                                <td>{{ $invoice->customer_email }}</td>
                            </tr>
                            <tr>
                                <th>Customer mobile</th>
                                <td>{{ $invoice->customer_mobile }}</td>
                                <th>Company name</th>
                                <td>{{ $invoice->company_name }}</td>
                            </tr>
                            <tr>
                                <th>Invoice number</th>
                                <td>{{ $invoice->invoice_number }}</td>
                                <th>Invoice date</th>
                                <td>{{ $invoice->invoice_date }}</td>
                            </tr>
                        </table>

                        <h3>Invoice details</h3>

                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Product name</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Unit price</th>
                                <th>Product subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoice->details as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->unitText() }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->unit_price }}</td>
                                    <td>{{ $item->row_sub_total }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="2">Sub total</th>
                                <td>{{ $invoice->sub_total }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="2">Discount</th>
                                <td>{{ $invoice->discountResult() }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="2">Vat</th>
                                <td>{{ $invoice->vat_value }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="2">Shipping</th>
                                <td>{{ $invoice->shippint }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <th colspan="2">Total due</th>
                                <td>{{ $invoice->total_due }}</td>
                            </tr>

                            </tfoot>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="{{ route('invoices.pdf', $invoice->id) }}" class="btn btn-secondary btn-sm ml-auto"><i class="fa fa-file-pdf"></i> Export PDF</a>
                            <a href="{{ route('invoices.send_to_email', $invoice->id) }}" class="btn btn-success btn-sm ml-auto"><i class="fa fa-envelope"></i> Send to email</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
