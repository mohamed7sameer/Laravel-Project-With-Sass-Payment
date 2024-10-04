<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_mobile' => 'required|numeric',
            'company_name' => 'required',
            'invoice_number' => 'required',
            'invoice_date' => 'required|date',

            'product_name' => 'required|array',
            'unit' => 'required|array',
            'quantity' => 'required|array',
            'unit_price' => 'required|array',
            'row_sub_total' => 'required|array',

            'product_name.*' => 'required|string',
            'unit.*' => 'required_with:product_name',
            'quantity.*' => 'required_with:product_name',
            'unit_price.*' => 'required_with:product_name',
            'row_sub_total.*' => 'required_with:product_name',

            'sub_total' => 'required',
            'discount_type' => 'required',
            'discount_value' => 'required',
            'vat_value' => 'required',
            'shipping' => 'nullable|numeric',
            'total_due' => 'required',


        ];
    }
}
