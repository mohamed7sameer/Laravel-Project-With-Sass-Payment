@extends('layouts.app')
@section('style')
    <style>
        .was-validated .form-control:invalid, .form-control.is-invalid {
            border: 1px solid #ced4da;
            background: none;
        }
        .was-validated .form-control:valid, .form-control.is-valid {
            border: 1px solid #ced4da;
            background: none;
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Create invoice
                </div>

                <div class="card-body">
                    <form action="{{ route('invoices.do_send_to_email', $invoice->id) }}" method="post" class="form" id="form">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="emails">Emails:</label>
                                    <input type="text" name="emails" class="form-control">
                                    <span class="text-info">Separate emails by comma (,)</span>
                                    @error('emails')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="body">Body</label>
                                    <textarea name="body" class="form-control" rows="5"></textarea>
                                    <span class="text-info">If invoice available, it will be attached to email automatically.</span>
                                    @error('body')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-right pt-3">
                            <button type="submit" class="btn btn-primary">Send Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\InvoiceSendRequest', '#form'); !!}
@endsection
