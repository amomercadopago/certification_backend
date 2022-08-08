<?php

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class PreferenceWebhook implements RequestHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
//         $body = json_decode($request->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        $this->logger->info('Webhook: ' . stripcslashes($request->getBody()->getContents()), []);
        return new JsonResponse([]);

    }
}
