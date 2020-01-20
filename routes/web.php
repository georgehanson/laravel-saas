<?php

Route::group(['prefix' => 'saas', 'middleware' => ['web']], function ($router) {
    Route::post('/subscribe', '\GeorgeHanson\SaaS\Http\Controllers\SubscriptionController@subscribe');
});