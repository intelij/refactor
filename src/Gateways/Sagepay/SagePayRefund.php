<?php


namespace DivideBuy\Payment\Gateways\Sagepay;

class SagePayRefund  extends Direct implements SagePayContract
{
    /**
     * Refund a payment
     *
     * @param $transactionType
     * @return mixed
     */
    public function process($transactionType)
    {
        if (in_array(strtoupper($transactionType), $this->validTxTypes)) {
            $transactionType = strtoupper($transactionType);
        } else {
            throw new \InvalidArgumentException("Invalid TxType given");
        }

        $this->setAuthHeader('Basic ' . config('sagepay.key'));

        $apiEndPoint = 'transactions';

        $postData = [
            'vendorName' => config('sagepay.vendor_name'),
            'transactionType' => $transactionType,
            'vendorTxCode' => $this->getVendorTxCode(),
            'amount' => $this->amount,
            'currency' => $this->getCurrency(),
            'referenceTransactionId' => $this->getTransactionId(),
            'description' => $this->getDescription(),
        ];

        $response = $this->makeRequest($apiEndPoint, 'post', $postData);

        return $response->getBody()->getContents();

    }

}
