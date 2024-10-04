<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\InvoiceSendRequest;
use App\Mail\SendInvoice;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('check.invoice.ability')->only(['create', 'store', 'pdf', 'send_to_email', 'do_send_to_email']);
    }

    public function index()
    {
        // $invoices = Invoice::whereUserId(auth()->id())->orderBy('id', 'desc')->paginate(10);
        $invoices = auth()->user()->invoices()->orderBy('id', 'desc')->paginate(10);
        return view('frontend.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('frontend.invoices.create');
    }

    public function store(InvoiceRequest $request)
    {
        $invoice = auth()->user()->invoices()->create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_mobile' => $request->customer_mobile,
            'company_name' => $request->company_name,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'sub_total' => $request->sub_total,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'vat_value' => $request->vat_value,
            'shipping' => $request->shipping,
            'total_due' => $request->total_due,
        ]);

        $details_list = [];
        for ($i = 0; $i < count($request->product_name); $i++) {
            $details_list[$i]['product_name'] = $request->product_name[$i];
            $details_list[$i]['unit'] = $request->unit[$i];
            $details_list[$i]['quantity'] = $request->quantity[$i];
            $details_list[$i]['unit_price'] = $request->unit_price[$i];
            $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];
        }

        $details = $invoice->details()->createMany($details_list);

        if ($details) {
            return redirect()->back()->with([
                'message' => 'Created successfully',
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Created failed',
                'alert-type' => 'danger'
            ]);
        }
    }

    public function show(Invoice $invoice)
    {
        return view('frontend.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('frontend.invoices.edit', compact('invoice'));
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_mobile' => $request->customer_mobile,
            'company_name' => $request->company_name,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'sub_total' => $request->sub_total,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'vat_value' => $request->vat_value,
            'shipping' => $request->shipping,
            'total_due' => $request->total_due,
        ]);

        $invoice->details()->delete();

        $details_list = [];
        for ($i = 0; $i < count($request->product_name); $i++) {
            $details_list[$i]['product_name'] = $request->product_name[$i];
            $details_list[$i]['unit'] = $request->unit[$i];
            $details_list[$i]['quantity'] = $request->quantity[$i];
            $details_list[$i]['unit_price'] = $request->unit_price[$i];
            $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];
        }

        $details = $invoice->details()->createMany($details_list);

        if ($details) {
            return redirect()->back()->with([
                'message' => 'Updated successfully',
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Updated failed',
                'alert-type' => 'danger'
            ]);
        }
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice) {
            $invoice->delete();
            return redirect()->route('invoices.index')->with([
                'message' => 'Deleted successfully',
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('invoice.index')->with([
                'message' => 'Deleted failed',
                'alert-type' => 'danger'
            ]);
        }

    }

    public function pdf($id)
    {
        $invoice = Invoice::whereId($id)->first();

        $data['invoice_id']         = $invoice->id;
        $data['invoice_date']       = $invoice->invoice_date;
        $data['customer']           = [
            'Customer name'         => $invoice->customer_name,
            'Customer mobile'       => $invoice->customer_mobile,
            'Customer email'        => $invoice->customer_email
        ];
        $items = [];
        $invoice_details            =  $invoice->details()->get();
        foreach ($invoice_details as $item) {
            $items[] = [
                'product_name'      => $item->product_name,
                'unit'              => $item->unitText(),
                'quantity'          => $item->quantity,
                'unit_price'        => $item->unit_price,
                'row_sub_total'     => $item->row_sub_total,
            ];
        }
        $data['items'] = $items;

        $data['invoice_number']     = $invoice->invoice_number;
        $data['created_at']         = $invoice->created_at->format('Y-m-d');
        $data['sub_total']          = $invoice->sub_total;
        $data['discount']           = $invoice->discountResult();
        $data['vat_value']          = $invoice->vat_value;
        $data['shipping']           = $invoice->shipping;
        $data['total_due']          = $invoice->total_due;

        $pdf = PDF::loadView('frontend.invoices.pdf', $data);

        $pdf_path = public_path('assets/invoices/').$invoice->invoice_number.'.pdf';

        $pdf->save($pdf_path);

        $invoice->invoices_uploads()->create([
            'user_id' => auth()->id(),
            'invoice_name' => $invoice->invoice_number,
            'invoice_path' => 'assets/invoices/'.$invoice->invoice_number.'.pdf',
            'invoice_size' => Storage::size($invoice->invoice_number.'.pdf'),
        ]);

        return redirect()->route('invoices.index')->with([
            'message' => 'PDF created successfully',
            'alert-type' => 'success'
        ]);

    }

    public function send_to_email($id)
    {
        $invoice = Invoice::whereId($id)->whereUserId(auth()->id())->first();
        return view('frontend.invoices.send_email', compact('invoice'));
    }

    public function do_send_to_email(InvoiceSendRequest $request, $id)
    {
        $invoice = Invoice::whereId($id)->whereUserId(auth()->id())->first();
        if (Str::contains($request->emails, [','])){
            $emails = explode(',', $request->emails);
        } else {
            $emails[] = $request->emails;
        }

        foreach ($emails as $email) {
            Mail::to($email)->send(new SendInvoice($invoice, $request->body));
        }

        $invoice->invoices_sent()->create([
            'user_id' => auth()->id(),
            'emails' => $request->emails,
            'body' => $request->body,
        ]);

        return redirect()->route('invoices.index')->with([
            'message' => 'Email sent successfully',
            'alert-type' => 'success'
        ]);

    }

}
