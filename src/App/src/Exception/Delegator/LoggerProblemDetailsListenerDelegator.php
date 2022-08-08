<?php

namespace App\Exception\Delegator;

use App\Exception\Listener\ErrorListener;
use Mezzio\ProblemDetails\ProblemDetailsMiddleware;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class LoggerProblemDetailsListenerDelegator
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        ?string $serviceName,
        callable $callback
    ): ProblemDetailsMiddleware {
        /** @var ProblemDetailsMiddleware $middleware */
        $middleware = $callback();

        $middleware->attachListener($container->get(ErrorListener::class));

        return $middleware;
    }
}