<?php

declare(strict_types=1);

namespace App\Factory;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Exception\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;

class EntityManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @return EntityManager
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     */
    public function __invoke(ContainerInterface $container): EntityManager
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
        $rootDir = "{$documentRoot}/..";

        $config = new Configuration;
        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyDir($rootDir . $container->get('config')['doctrine']['proxy_dir']);
        $config->setProxyNamespace('Proxy');
        $config->setMetadataDriverImpl(
            $config->newDefaultAnnotationDriver("$rootDir/src/", false)
        );

        if (getenv('DEV_MODE') === 'true') {
            $config->setQueryCache(new ArrayAdapter);
            $config->setMetadataCache(new ArrayAdapter);
        } else {
            $config->setQueryCache(new PhpFilesAdapter('doctrine_queries'));
            $config->setMetadataCache(new PhpFilesAdapter('doctrine_metadata'));
        }

        return EntityManager::create($container->get('config')['migrations_db'], $config);
    }
}