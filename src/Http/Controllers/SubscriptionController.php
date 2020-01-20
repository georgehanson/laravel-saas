<?php


namespace GeorgeHanson\SaaS\Http\Controllers;

use GeorgeHanson\SaaS\SaaS;
use GeorgeHanson\SaaS\Services\PaymentGateway;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Subscribe the user to the plan.
     *
     * @param Request $request
     * @param PaymentGateway $gateway
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subscribe(Request $request, PaymentGateway $gateway)
    {
        $request->validate(['plan' => 'required']);
        $session = $gateway->createSessionToken(SaaS::tenant())->forPlan($request->get('plan'))->create();

        return view('saas::checkout', [
            'sessionId' => $session->id
        ]);
    }

    /**
     * Update the subscription.
     * @param PaymentGateway $gateway
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(PaymentGateway $gateway)
    {
        $session = $gateway->createSessionToken(SaaS::tenant())->toUpdate();

        return view('saas::checkout', [
            'sessionId' => $session->id
        ]);
    }
}