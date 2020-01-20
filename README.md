# Laravel SaaS Starter Kit

This is designed to be a starting point for building multi-tenanted SaaS applications in Laravel. The goal of this project
is to have all of the heavy lifting done in regards to multi-tenancy including authentication, billing, invoice generation,
two factor authentication etc all with an easy to consume API and SDK.

## To Do
- [x] Multi Tenancy
- [ ] Subscription Payments
- [ ] Invoice Generation
- [ ] Two Factor Authentication

## Documentation

### Multi Tenancy
For multi-tenancy, you simply need to include the `GeorgeHanson\SaaS\Database\Traits\Tenantable` trait on the model. This
will ensure that each record is created with the correct tenant id and that a query scope is added so the tenant only sees
their data. It is also important that when creating your migrations for these resources to include a `tenant_id` column which
should be an unsigned integer.

### Subscription Payments

This package offers built in subscription payments. This options for this can be configured within the config file.
There you can enable/disable billing as well as specifying which payment gateway you would like to use and the relevant
API credentials for it. For security we recommend storing the API keys within an environment variable rather than hardcoding
them straight into the configuration.

Currently this package only supports Stripe.

If billing is enabled, when a tenant is created using the Tenant service, it automatically registers a customer within
Stripe and stores their customer id. This is used later on for adding cards, taking payments and more.

In order to create a plan, we recommend adding the code within a service provider. You can use your `AppServiceProvider`
or create your own custom one. Here you can call the `plan` method on the `SaaS` class. For example:

```php
public function boot()
{
    SaaS::plan('My Plan', 'stripe-plan-id');
}
```

The above code will register a plan with the package.

To subscribe the user to the a plan you need to make a form request to the SaaS subscribe endpoint, including the plan
name within the request. For example, you may have a form like this on your page.

```blade
<form action="{{ SaaS::subscribeUrl() }}" method="POST">
    @csrf
    <input type="hidden" name="plan" value="My Plan">
    <div class="card mb-4 box-shadow">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">Enterprise</h4>
        </div>
        <div class="card-body">
            <h1 class="card-title pricing-card-title">£19.99 <small class="text-muted">/ mo</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
                <li>30 users included</li>
                <li>15 GB of storage</li>
                <li>Phone and email support</li>
                <li>Help center access</li>
            </ul>
            <button type="submit" class="btn btn-lg btn-block btn-primary">Sign Up</button>
        </div>
    </div>
</form>
```

Then when the user submits the form, they will be taken to Stripes Checkout page where they can enter their relevant card
details. Once complete they will be returned to the urls specified within the `saas.php` config file.

#### Webhooks Configuration
This package utilises Stripes webhooks extensively so it is important that these are configured correctly. Please review the Stripe
documentation for creating a Webhook key. Once this key has been created you can store this within your environment variable which is
referenced by the config. It is also important to add the following to your `VerifyCsrfToken` middleware.

```php
/**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'saas/hooks'
    ];
```

You can check the status of a tenants subscription using some helper methods. The following method can be called to see if
the subscription is currently active, but will expire soon and not be renewed.

```php
SaaS::subscriptionEndingSoon();
```

You can use the following method to check if the tenant has an active subscription.

```php
SaaS::isSubscribed();
```

WIP
