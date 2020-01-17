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

WIP
