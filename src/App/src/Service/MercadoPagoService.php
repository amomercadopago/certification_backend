<?php

namespace App\Service;

use App\Client\MercadoPagoClient;
use App\Entity\Account;
use App\Enum\WebhookEnum;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;

class MercadoPagoService
{
    private string $baseUrl;
    private MercadoPagoClient $mercadoPagoClient;
    private const TOKEN = 'APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398';

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(MercadoPagoClient $mercadoPagoClient, ContainerInterface $container)
    {
        $this->mercadoPagoClient = $mercadoPagoClient;
        $this->baseUrl = $container->get('config')['integration']['base_url'];
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function createPreference(array $data): array
    {
        return $this->mercadoPagoClient->createPreference(
            self::TOKEN,
            $this->prepareArrayForCreatePreference($data)
        );
    }

    private function prepareArrayForCreatePreference(array $data): array
    {
        return [
            'payer' => [
                'name' => $data['payer']['name'],
                'surname' => $data['payer']['surname'],
                'email' => $data['payer']['email'],
                'phone' => [
                    'area_code' => $data['payer']['phone']['area_code'],
                    'number' => $data['payer']['phone']['number'],
                ],
                'address' => [
                    'street_name' => $data['payer']['address']['street'],
                    'street_number' => $data['payer']['address']['homeNumber'],
                    'zip_code' => $data['payer']['address']['postIndex'],
                ],
            ],
            'items' => $data['products'],
            'external_reference' => 'alodia@team.amocrm.com',
            'back_urls' => [
                'success' => 'https://amomercadopago.github.io/?page=payment&result=success',
                'pending' => 'https://amomercadopago.github.io/?page=payment&result=pending',
                'failure' => 'https://amomercadopago.github.io/?page=payment&result=failure',
            ],
            'payment_methods' => [
                'excluded_payment_methods' => [
                    ['id' => 'visa'],
                ],
                'installments' => 6,
            ],
            'auto_return' => 'approved',
            'notification_url' => "$this->baseUrl/webhook"
        ];
    }
}