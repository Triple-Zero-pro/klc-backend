<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

// use Illuminate\Http\Request;

class FatooorahServices
{
    private $base_url;
    private $headers;
    private $request_client;

    /**
     *FatooraServices Constructor.
     * @param Client $request_client
     */

    public function __Construct(Client $request_client)
    {
        $this->request_client = $request_client;
        $this->base_url = 'https://pg.bookeey.com/internalapi/api/payment/';

        $this->headers = [
            'Content-Type' => "application/json",
            'hashMac' => env("Tooken")
        ];
    }

    /**
     * @param $url
     * @param $method
     * @param array $body
     * @return falselmixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */


    private function buildRequest($url, $method, $data = [])
    {

        $request = new Request("POST", $this->base_url . $url, $this->headers);
        if (!$data)
            return false;
        $response = $this->request_client->send($request, [
            'json' => $data
        ]);


        if ($response->getStatusCode() != 200) {
            return false;
        }

        $response = Json_decode($response->getBody(), true);

        return $response;
    }

    /**
     * @param $data
     */


    public function sendPayment($data)
    {
        // dd($data);

        $response = $this->buildRequest('requestLink', 'POST', $data);
        // dd($response);
        return $response;

        // return print_r($response);
        // return  $response;
    }


    public function getPayneltstatus($dataStats)
    {
        return $response = $this->buildRequest('paymentstatus', 'GET', $dataStats);
    }
}
