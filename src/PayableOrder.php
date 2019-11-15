<?php

namespace DivideBuy\Payment;

interface PayableOrder
{

    /**
     * Should be in pence/cents (hundredth) for most payments providers.
     *
     * @return float
     */
    public function getPaymentAmount();

    /**
     * @return string
     */
    public function getPaymentDescription();

    /**
     * @return string
     */
    public function getCustomerEmail();

}
