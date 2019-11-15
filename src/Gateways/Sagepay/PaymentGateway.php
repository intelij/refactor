<?php

namespace DivideBuy\Payment\Gateways\Sagepay;

use DivideBuy\Payment\PayableOrder;
use DivideBuy\Payment\PaymentGateway as PaymentGatewayInterface;
use Input;
use View;

class PaymentGateway implements PaymentGatewayInterface
{
    protected $order;

    /**
     * Set the payable order.
     *
     * @param PayableOrder $order
     *
     * @return PaymentGatewayInterface
     */
    public function setOrder(PayableOrder $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the payment form.  This will automatically redirect to SAGE Pay iFrame form
     *
     * @return string
     */
    public function getPaymentForm($attributes = [])
    {
        // need to pull our request response from SAGE to prepopulate the form
        $order = $this->order;

        View::addNamespace('payment', __DIR__);

        return View::make('payment::form')->with(compact('order', 'hash', 'attributes'));
    }

    /**
     * Validate the gateway response.
     *
     * @param mixed $orderId
     * @param array $gatewayResponse
     *
     * @return bool
     */
    public function validateGatewayResponse($orderId, $gatewayResponse = null)
    {
        $gatewayResponse = $gatewayResponse ?: Input::all();

        return (new PaymentGatewayResponseValidator($orderId, $gatewayResponse))->validate();
    }

    /**
     * Determine the result of the payment
     * If gatewayResponse is null, Input::all() will be used.
     *
     * @param array $gatewayResponse
     *
     * @return string
     */
    public function getPaymentResult($gatewayResponse = null)
    {
        $gatewayResponse = $gatewayResponse ?: Input::all();

        switch ($gatewayResponse['Status']) {
            case 'AU':
                $paymentResult = self::PAYMENT_RESULT_OK;
                break;
            case 'DE':
                $paymentResult = self::PAYMENT_RESULT_DECLINED;
                break;
            case 'CA':
                $paymentResult = self::PAYMENT_RESULT_CANCELLED_BY_CARDHOLDER;
                break;
            case 'TI':
                $paymentResult = self::PAYMENT_TIMED_OUT;
                break;
            case 'EX':
            default:
                $paymentResult = self::PAYMENT_RESULT_FAILED;
                break;
        }

        return $paymentResult;
    }

}
