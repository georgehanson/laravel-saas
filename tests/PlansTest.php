<?php

namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\SaaS;

class PlansTest extends TestCase
{
    public function testAPlanCanBeCreated()
    {
        SaaS::plan('My Plan', 'my-plan');

        $plans = SaaS::getPlans();

        $this->assertCount(1, $plans);

        $saved = $plans->first();

        $this->assertEquals('My Plan', $saved->getName());
        $this->assertEquals('my-plan', $saved->getStripeId());
    }
}
