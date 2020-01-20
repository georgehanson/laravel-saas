<?php


namespace GeorgeHanson\SaaS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HooksController extends Controller
{
    /**
     * Handle the request.
     *
     * @param Request $request
     */
    public function handle(Request $request)
    {
        Log::info($request);
    }
}