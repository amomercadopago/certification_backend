<?php

declare(strict_types=1);

namespace App\Exception\Listener;

use App\Exception\Helper\LogHelper;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Exception;
use Error;

class ErrorListener
{
    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Throwable $error, ServerRequestInterface $request, ResponseInterface $response): void
    {
        $context = LogHelper::convertException($error);

        if ($error instanceof Error) {
            $this->logger->error($error->getMessage(), $context);
        } elseif (!$error instanceof ProblemDetailsExceptionInterface) {
            if ($error instanceof Exception) {
                $this->logger->critical($error->getMessage(), $context);
            } elseif ($error instanceof Throwable) {
                $this->logger->warning($error->getMessage(), $context);
            }
        }
    }
}
