<?php


namespace DivideBuy\Payment\Gateways\Sagepay;

class SagePayPayment extends Direct implements SagePayContract
{
    /**
     * Register a Payment with Sagepay
     *
     * @param $transactionType
     * @return mixed
     * @throws \Exception
     */
    public function process($transactionType)
    {

        if (in_array(strtoupper($transactionType), $this->validTxTypes)) {
            $transactionType = strtoupper($transactionType);
        } else {
            throw new \InvalidArgumentException("Invalid TxType given");
        }

        $this->generateMerchantSessionKey();

        $request = $this->generateCardIdentifier();

        $this->setCardIdentifier(json_decode($request->getBody()->getContents())->cardIdentifier);

        $postData = [
            'transactionType' => "Payment",
            'paymentMethod' => [
                'card' => [
                    'merchantSessionKey' => $this->getMerchantSessionKey(),
                    'cardIdentifier' => $this->getCardIdentifier(),
                    'save' => false
                ]
            ],
            'vendorTxCode' => $this->getVendorTxCode(),
            'amount' => $this->amount,
            'currency' => $this->getCurrency(),
            'description' => $this->getDescription(),
            'apply3DSecure' => "UseMSPSetting",
            'customerFirstName' => $this->billingAddress->firstname,
            'customerLastName' => $this->billingAddress->surname,
            'billingAddress' => [
                'address1' => $this->deliveryAddress->address1,
                'address2' => $this->deliveryAddress->address2,
                'city' => $this->deliveryAddress->city,
                'postalCode' => $this->deliveryAddress->postcode,
                'country' => $this->billingAddress->country ? $this->billingAddress->country : config('sagepay.currency'),
            ],
            'entryMethod' => $this->accountType
        ];

        return $this->secureProcess($postData);

    }

}
