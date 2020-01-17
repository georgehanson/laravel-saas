<?php


namespace GeorgeHanson\SaaS\Tests\Resources;

use GeorgeHanson\SaaS\Database\Traits\Tenantable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Tenantable;

    protected $guarded = [];
}