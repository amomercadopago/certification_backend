<?php

declare(strict_types=1);

namespace App\Exception\Helper;

use GuzzleHttp\Exception\RequestException;
use Laminas\Json\Json;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

use function get_class;

class LogHelper
{
    public static function convertException(Throwable $exception): array
    {
        $result = [
            'type'    => get_class($exception),
            'message' => $exception->getMessage(),
            'code'    => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];

        if ($exception instanceof RequestException) {
            $response = $exception->getResponse();

            if ($response) {
                $result['response'] = self::convertResponse($response);
            }
        }

        if ($previous = $exception->getPrevious()) {
            $result['previous'] = self::convertException($previous);
        }

        return $result;
    }

    public static function convertMessage(MessageInterface $message): array
    {
        $convertException = $contents = $body = null;

        try {
            $contents = (string) $message->getBody()->getContents();
            if ($contents) {
                $body = Json::decode($contents, Json::TYPE_ARRAY);
            }
        } catch (Throwable $exception) {
            $convertException = $exception;
        }

        return [
            'contents'         => $contents,
            'body'             => $body,
            'convertException' => $convertException ? self::convertException($convertException) : null,
        ];
    }

    public static function convertResponse(ResponseInterface $response): array
    {
        return self::convertMessage($response) + [
                'status' => $response->getStatusCode(),
            ];
    }
}
