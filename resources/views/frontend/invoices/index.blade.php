@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h2>Invoices</h2>
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary ml-auto"><i class="fa fa-plus"></i> Create invoice</a>
                </div>

                <div class="table-responsive">
                    <table class="table card-table">
                        <thead>
                        <tr>
                            <th>Customer name</th>
                            <th>Invoice PDF</th>
                            <th>Invoice date</th>
                            <th>Total due</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td><a href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->customer_name }}</a></td>
                                <td>
                                @if ($invoice->invoices_pdf($invoice->id))
                                    {{ \Illuminate\Support\Facades\Storage::url($invoice->invoices_pdf($invoice->id)->invoice_path) }} ({{ size_as_kb($invoice->invoices_pdf($invoice->id)->invoice_size) }})
                                @else
                                    {{ '-' }}
                                @endif

                                </td>
                                <td>{{ $invoice->invoice_date }}</td>
                                <td>{{ $invoice->total_due }}</td>
                                <td>
                                    @if(auth()->user()->canUploadInvoice())
                                        <a href="{{ route('invoices.upload_invoice', $invoice->id) }}" class="btn btn-success btn-sm"><i class="fa fa-file-pdf"></i></a>
                                    @else
                                        <a href="javascript:void(0)" title="This feature is not active in your plan" class="btn btn-dark btn-sm"><i class="fa fa-file-pdf"></i></a>
                                    @endif

                                    @if(auth()->user()->canSendInvoiceEmail())
                                        <a href="{{ route('invoices.send_to_email', $invoice->id) }}" class="btn btn-info btn-sm"><i class="fa fa-mail-bulk"></i></a>
                                    @else
                                            <a href="javascript:void(0)" title="This feature is not active in your plan" class="btn btn-dark btn-sm"><i class="fa fa-mail-bulk"></i></a>
                                    @endif

                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="if (confirm('Are you sure to delete this record?')) { document.getElementById('delete-{{ $invoice->id }}').submit(); } else { return false; }" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="post" id="delete-{{ $invoice->id }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="float-right">
                                    {!! $invoices->links() !!}
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
