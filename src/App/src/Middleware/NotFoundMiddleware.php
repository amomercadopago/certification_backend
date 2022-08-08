<?php

declare(strict_types=1);

namespace App\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->getAttribute(RouteResult::class)->isSuccess()) {
            return new JsonResponse([
                'status' => StatusCodeInterface::STATUS_NOT_FOUND,
                'error' => 'Not found',
            ], StatusCodeInterface::STATUS_NOT_FOUND);
        }

        return $handler->handle($request);
    }
}
