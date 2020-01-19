<?php

namespace GeorgeHanson\SaaS\Plans;

class Plan
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $stripeId;

    /**
     * @var int
     */
    protected $price;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Plan
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getStripeId()
    {
        return $this->stripeId;
    }

    /**
     * @param string $stripeId
     * @return Plan
     */
    public function setStripeId($stripeId)
    {
        $this->stripeId = $stripeId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Plan
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Create the plan.
     *
     * @return Plan
     */
    public function create()
    {
        Plans::addPlan($this);

        return $this;
    }
}