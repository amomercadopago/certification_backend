<?php

namespace App\Handler;

use App\Entity\Account;
use App\Service\MercadoPagoService;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class PreferenceCreateHandler implements RequestHandlerInterface
{
    private MercadoPagoService $mercadoPagoService;

    public function __construct(MercadoPagoService $mercadoPagoService)
    {
        $this->mercadoPagoService = $mercadoPagoService;
    }

    /**
     * @throws \JsonException
     */
    public function handle(ServerRequestInterface $request): Response
    {
        return new Response\JsonResponse($this->mercadoPagoService->createPreference(
            json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR),
        ));
    }
}
