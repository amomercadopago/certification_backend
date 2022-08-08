<?php

namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Container\ContainerInterface;

class MercadoPagoClient
{
    private ClientInterface $httpClient;

    private string $baseUrl;
    private string $requestUrl;

    public function __construct(ContainerInterface $container)
    {
        $this->httpClient = new Client;
        $this->baseUrl = $container->get('config')['integration']['base_url'];
        $this->requestUrl = $container->get('config')['mercado_pago']['request_url'];
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function createPreference(string $accessToken, array $data): array
    {
        $response = $this->httpClient->request(
            'POST',
            "$this->requestUrl/checkout/preferences",
            [
                'headers' => [
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $accessToken",
                    'x-integrator-id' => "dev_24c65fb163bf11ea96500242ac130004",
                ],
                'json' => $data,
            ],
        );
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

    }
}
