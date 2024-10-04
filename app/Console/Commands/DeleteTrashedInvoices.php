<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteTrashedInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Trashed Invoices';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Invoice::withTrashed()->whereNotNull('deleted_at')->whereDate('created_at', '!=', today())->forceDelete();
        Log::alert('Trashed invoices deleted successfully!');
    }
}
