<?php

namespace DivideBuy\Payment\Gateways\Sagepay;

class SagePayRepeat extends Direct implements SagePayContract
{
    /**
     * Repeat/Recurring Payment with Sagepay
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

        $postData = [
            'transactionType' => $this->getTransactionType(),
            'referenceTransactionId' => $this->relatedVendorTxCode,
            'vendorTxCode' => $this->getVendorTxCode(),
            'amount' => $this->amount,
            'currency' => $this->getCurrency(),
            'description' => "Repeat Payment",
            'shippingDetails' => [
                'recipientFirstName' => $this->deliveryAddress->firstname,
                'recipientLastName' => $this->deliveryAddress->surname,
                'shippingAddress1' => $this->deliveryAddress->address1,
                'shippingAddress2' => $this->deliveryAddress->address2,
                'shippingCity' => $this->deliveryAddress->city,
                'shippingPostalCode' => $this->deliveryAddress->postcode,
                'shippingCountry' => $this->billingAddress->country ? $this->billingAddress->country : config('sagepay.currency'),
            ],
        ];

        $this->setAuthHeader('Basic ' . config('sagepay.key'));

        $apiEndPoint = 'transactions';

        $response = $this->makeRequest($apiEndPoint, 'post', $postData)->getBody()->getContents();

        return $response;

    }
}
