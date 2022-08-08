<?php

declare(strict_types=1);

use App\Handler\PreferenceCreateHandler;
use App\Handler\PreferenceWebhook;
use Mezzio\Application;

return function (Application $app): void {
    $app->route(
        '/preference/create',
        PreferenceCreateHandler::class,
        ['POST'],
        'preference.create'
    );
    $app->route(
        '/webhook',
        PreferenceWebhook::class,
        ['POST'],
        'webhook'
    );
};
