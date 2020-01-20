<?php

Route::group(['prefix' => 'saas'], function ($router) {
    Route::post('/subscribe', '\GeorgeHanson\SaaS\Http\Controllers\SubscriptionController@subscribe');
});