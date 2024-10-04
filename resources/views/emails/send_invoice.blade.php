@extends('layouts.emails')
@section('content')

    <h3>Dear: {{ $invoice->customer_name }}</h3>

    @if($body != '')
        <p>{!! $body !!}</p>
    @endif

@endsection
