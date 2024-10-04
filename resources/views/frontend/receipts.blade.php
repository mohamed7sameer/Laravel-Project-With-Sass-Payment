@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-header">Receipts</div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    @include('partial.frontend.sidebar')
                </div>
                <div class="col-8">
                    <h2 class="h5 text-uppercase mb-4">Receipts</h2>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Paid at</th>
                            <th>Amount</th>
                            <th>Receipt</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($receipts as $receipt)
                            <tr>
                                <td>{{ $receipt->paid_at->toFormattedDateString() }}</td>
                                <td>{{ $receipt->amount() }}</td>
                                <td><a href="{{ $receipt->receipt_url }}" target="_blank">Download</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
