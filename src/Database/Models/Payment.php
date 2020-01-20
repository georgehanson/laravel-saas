<?php


namespace GeorgeHanson\SaaS\Database\Models;

use GeorgeHanson\SaaS\Database\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes, Tenantable;

    protected $table = 'tenant_payments';

    protected $guarded = [];
}
