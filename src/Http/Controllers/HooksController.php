<?php


namespace GeorgeHanson\SaaS\Http\Controllers;

use GeorgeHanson\SaaS\Exceptions\WebhookCouldNotBeVerifiedException;
use GeorgeHanson\SaaS\Services\Webhooks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HooksController extends Controller
{
    /**
     * Handle the request.
     *
     * @param Request $request
     * @param Webhooks $webhooks
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Webhooks $webhooks)
    {
        try {
            $event = $webhooks->verify($request->json(), $request->header('HTTP_STRIPE_SIGNATURE'));
            $webhooks->handle($event);

            return response()->json(['message' => 'Success'], 200);
        } catch (WebhookCouldNotBeVerifiedException $exception) {
            return response()->json(['Failed verification'], 403);
        }
    }
}
