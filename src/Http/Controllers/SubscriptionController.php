<?php

namespace Silentz\Charge\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Statamic\Http\Controllers\Controller;
use Silentz\Charge\Http\Middleware\HasSubscription;
use Silentz\Charge\Http\Requests\CreateSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(HasSubscription::class)->except('store');
    }

    public function show(string $name): ?Subscription
    {
        return current_user()->subscription($name);
    }

    public function store(CreateSubscriptionRequest $request): Subscription
    {
        $request->validated();

        return current_user()
            ->newSubscription($request->subscription, $request->plan)
            ->create($request->payment_method);
    }

    public function destroy(string $name, Request $request): Subscription
    {
        $subscription = current_user()->subscription($name);

        return $request->cancel_immediately ? $subscription->cancelNow() : $subscription->cancel();
    }
}
