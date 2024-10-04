<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InvoicesAbility
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->subscriptionInfo() != 'Free'){
            if ($request->routeIs('invoices.create') || $request->routeIs('invoices.store')) {
                if (!$request->user()->canAddInvoice()) {
                    return  redirect()->route('invoices.index')->with([
                        'message' => 'You can not add invoices today, if you want to add more please upgrade your subscription plan.',
                        'alert-type' => 'warning'
                    ]);
                }
            }

            if ($request->routeIs('invoices.upload_invoice')) {
                if (!$request->user()->canUploadInvoice()) {
                    return  redirect()->route('invoices.index')->with([
                        'message' => 'You can not Upload invoices today, if you want to upload more please upgrade your subscription plan.',
                        'alert-type' => 'warning'
                    ]);
                }
            }

            if ($request->routeIs('invoices.send_to_email') || $request->routeIs('invoices.do_send_to_email')) {
                if (!$request->user()->canSendInvoiceEmail()) {
                    return  redirect()->route('invoices.index')->with([
                        'message' => 'You can not Send invoices today, if you want to send more please upgrade your subscription plan.',
                        'alert-type' => 'warning'
                    ]);
                }
            }

            return $next($request);
        }

        return redirect()->route('subscriptions')->with([
            'message' => 'You have not any active subscription plan, please subscribe now.',
            'alert-type' => 'danger',
        ]);


    }
}
