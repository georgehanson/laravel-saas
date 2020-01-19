<?php

namespace GeorgeHanson\SaaS\Tests;

use GeorgeHanson\SaaS\Plans\Plan;
use GeorgeHanson\SaaS\Plans\Plans;

class PlansTest extends TestCase
{
    public function testAPlanCanBeCreated()
    {
        $plan = (new Plan())
            ->setName('My Plan')
            ->setStripeId('1234')
            ->setPrice(999)
            ->create();

        $this->assertCount(1, Plans::getPlans());

        $saved = Plans::getPlans()[0];

        $this->assertEquals('My Plan', $saved->getName());
        $this->assertEquals('1234', $saved->getStripeId());
        $this->assertEquals(999, $saved->getPrice());
    }
}
