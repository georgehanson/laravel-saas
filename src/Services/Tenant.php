<?php

namespace GeorgeHanson\SaaS\Services;

class Tenant
{
    /**
     * Create a new tenant
     * @param $name
     * @return Tenant
     */
    public function create($name)
    {
        return \GeorgeHanson\SaaS\Database\Models\Tenant::create(['name' => $name]);
    }
}
