<?php


namespace GeorgeHanson\SaaS\Database\Traits;

use GeorgeHanson\SaaS\Database\Scopes\TenantableScope;
use Illuminate\Support\Facades\Auth;

trait Tenantable
{
    public static function bootTenantable()
    {
        static::creating(function ($model) {
            if ($user = Auth::user()) {
                $model->tenant_id = $user->tenant_id;
            }
        });

        static::addGlobalScope(new TenantableScope());
    }
}
