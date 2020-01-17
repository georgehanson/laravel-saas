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
         * Options: stripe
         */
        'provider' => 'stripe',

        'providers' => [
            'stripe' => [
                'api_key' => env('STRIPE_API_KEY', '')
            ]
        ]
    ],
];