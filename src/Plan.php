<?php

namespace GeorgeHanson\SaaS;

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
}
