<?php


namespace GeorgeHanson\SaaS\Database\Traits;

use GeorgeHanson\SaaS\Database\Models\Tenant;
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

    /**
     * The tenant for this tenantable instance.
     *
     * @return mixed
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
