<?php

namespace Silentz\Charge\Http\Requests;

class UpdateSubscriptionRequest extends SubscriptionRequest
{
    public function rules()
    {
        return [
            'plan' => 'required',
            'quantity' => 'sometimes|required|integer',
        ];
    }
}
