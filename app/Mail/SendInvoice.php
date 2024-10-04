<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, $body)
    {
        $this->invoice = $invoice;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject('New invoice')->view('emails.send_invoice');

        if ($this->invoice->invoices_pdf($this->invoice->id)){
            $this->attach(public_path('assets/invoices/').$this->invoice->invoice_number.'.pdf');
        }

        $this->with([
            'invoice' => $this->invoice,
            'body' => $this->body,
        ]);

        return $email;
    }
}
