<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscribeRequest extends FormRequest
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
        $plan_role = auth()->user()->hasSubscription()
            ? ['required', Rule::notIn([auth()->user()->subscriptionInfo()->id])]
            : ['required'];

        return [
            'plan' => $plan_role,
        ];
    }

    public function messages()
    {
        return [
            'plan.required' => 'The plan is required',
            'plan.not_in' => 'You are already subscribed to this plan.',
        ];
    }
}
