<?php


namespace DivideBuy\Payment\Gateways\Sagepay;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;

class SagePayThreeDSecure extends Direct implements SagePayContract
{

    private $responseReceived;
    private $md;
    private $paRes;

    public function __construct()
    {

        parent::__construct();

        $this->responseReceived = (object) $_REQUEST;
        $this->md = $this->responseReceived->MD;
        $this->paRes = $this->responseReceived->PaRes;
    }

    /**
     * Register a Payment with Sagepay
     *
     * @param $transactionType
     * @return mixed
     * @throws \Exception
     */
    public function process($transactionType)
    {

        $apiEndPoint = "transactions/{$this->md}/3d-secure";

        $apiEndPoint = env('SAGEPAY_URL') . $apiEndPoint;

        $client = new Client(
            [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->getAuthHeader()
                ],
                RequestOptions::JSON => [
                    'vendorName' => config('sagepay.vendor_name'),
                    'paRes' => $this->paRes,
                ]
            ]);

        try {

            $response = $client->post($apiEndPoint, []);

            return $response->getBody()->getContents();

        }  catch (ClientException $gce) {
            $response = json_decode($gce->getResponse()->getBody()->getContents());
            return json_encode(['error' => ['message' => $response->description, 'code' => $response->code]]);
        } catch (ServerException $gse) {
            $response = json_decode($gse->getResponse()->getBody()->getContents());
            return json_encode(['error' => ['message' => $response->description, 'code' => $response->code]]);
        } catch (\Exception $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());
            return json_encode(['error' => ['message' => $response->description, 'code' => $response->code]]);
        }

    }

}
