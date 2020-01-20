<?php

return [

    /**
     * This is the user model for the multi-tenancy. Please make this value equal to the class of
     * your authenticatable user model.
     */
    'user_model' => 'App\User',

    /**
     * Billing
     *
     * This is where all the billing configuration goes. Here you can enable/disable billing, set
     * which billing provider you would like to use and manage API credentials.
     */

    'billing' => [
        /**
         * Would you like to enable billing? This will automatically create a billing customer when a
         * tenant is created.
         *
         * Options: true, false
         */
        'enabled' => true,

        /**
         * Stripe settings.
         */
        'stripe' => [
            'secret_key' => env('STRIPE_SECRET_KEY', ''),
            'public_key' => env('STRIPE_PUBLIC_KEY', ''),
            'webhook_key' => env('STRIPE_WEBHOOK_KEY', '')
        ],
        /**
         * The url you would like to take the customer to when they successfully subscribe.
         */
        'success_url_redirect' => '',

        /**
         * The url you would like to take the customer to when they cancel during the subscribe process.
         */
        'cancel_url_redirect' => '',
    ],
];